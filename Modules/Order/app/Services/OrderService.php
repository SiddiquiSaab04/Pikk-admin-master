<?php

namespace Modules\Order\app\Services;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Modules\Customers\app\Services\CustomersCashbackService;
use Modules\Customers\app\Services\CustomersService;
use Modules\Inventory\app\Services\ProductService;
use Modules\Inventory\app\Services\StockService;
use Modules\Order\app\Events\OrderCancelledEvent;
use Modules\Order\app\Events\OrderPlacedEvent;
use Modules\Order\app\Events\OrderReadyEvent;
use Modules\Order\app\Events\OrderServedEvent;
use Modules\Order\app\Events\SendReadyOrderReminderEvent;
use Modules\Order\app\Repositories\OrderRepository;
use Modules\Order\app\Services\OrderProductService;
use Modules\Order\app\Services\OrderProductAddonService;
use Modules\Settings\app\Services\SettingsService;

class OrderService
{
    protected $model;
    protected $orderRepository;
    protected $orderProductService;
    protected $orderProductAddonService;
    protected $productService;
    protected $branch;
    protected $customerCashbackService;
    protected $customerService;
    protected $stock;
    protected $settingsService;

    public function __construct(
        ProductService $productService,
        OrderRepository $orderRepository,
        OrderProductService $orderProductService,
        OrderProductAddonService $orderProductAddonService,
        CustomersCashbackService $customerCashbackService,
        CustomersService $customerService,
        StockService $stock,
        SettingsService $settingsService
    ) {
        $this->model = "\\Modules\\Order\\app\\Models\\Order";
        $this->productService = $productService;
        $this->orderProductService = $orderProductService;
        $this->orderProductAddonService = $orderProductAddonService;
        $this->orderRepository = $orderRepository->initTable($this->model, request()->branch);
        $this->branch = request()->branch;
        $this->customerCashbackService = $customerCashbackService;
        $this->customerService = $customerService;
        $this->stock = $stock;
        $this->settingsService = $settingsService;
    }

    /**
     * get all orders from orders table
     */
    public function getAll()
    {
        return $this->orderRepository->paginate(20);
    }

    /**
     * create a new order
     *
     * @param array $data
     * @return Modules\Order\app\Models\Order collection
     */
    public function create($data, $auth)
    {
        $data['code'] = $this->getCode();
        $data['title'] = "null"; //wip
        $data['status'] = 'ongoing';
        $data['payment'] = 'paid';
        $data['total'] = 0;
        $data['sub_total'] = 0;
        $data['cancelled_reason'] = 0;
        $data['discount'] = $data['discount'];
        $data['discount_type'] = $data['discount_type'];

        if ($auth) {
            $data['customer_id'] = $auth->id;
        }
        /**
         * we are setting payload for all relevant models including:
         *
         * 1- \Modules\Order|app\Models\Order
         * 2- \Modules\Order\app\Models\OrderProduct
         * 3- \Modules\Order\app\Models\OrderProductAddon
         *
         * All of the listed models will be created using the arrays
         * below.
         */
        $orderProducts = $this->getOrderProducts($data);
        $payload = $this->getOrderProductAddons($orderProducts);
        $payload = $this->checkStocks($payload);

        if (isset($payload['status']) && $payload['status'] == 0) {
            return $payload;
        }

        if (isset($data['cashback']) && $data['cashback']) {
            $payload = $this->applyCashback($payload, $auth);
        }

        $order = $this->orderRepository->create($payload);

        if (!empty($order->id)) {
            foreach ($payload['orderProducts'] as $product) {
                $product['order_id'] = $order->id;
                $orderProduct = $this->orderProductService->create($product);

                foreach ($product['addons'] as $addon) {
                    $addon['order_id'] = $order->id;
                    $addon['order_product_id'] = $orderProduct->id;
                    $this->orderProductAddonService->create($addon);
                }
            }

            $this->applyStocks($payload);
        } else {
            return [
                "status" => 0,
                "message" => "Some error occurred while placing order"
            ];
        }

        /**
         * Return $x to customer if the order amount exceeds $10
         */

        if ($order->total > 0 && $auth) {
            $cashback = $this->settingsService->getDiscounts();
            $cashbackPercentage = json_decode($cashback[0]->value, true);

            $cashback = [
                "amount" => ($order->total / ((int) $cashbackPercentage['cashback'] ?? 10)),
                'customer_id' => $order->customer_id,
                'branch_id' => $this->branch,
                'status' => 0
            ];

            $this->customerCashbackService->createCashBack($cashback);
        }

        if (isset($payload['cashback_points']) && $auth) {
            $this->customerService->applyCashback($auth->id, $payload['cashback_points'], false);
        }

        $order = $this->orderProductService->getProductsByOrder($order);
        broadcast(new OrderPlacedEvent($order->toJson(), $this->branch))->toOthers();
        return $order;
    }

    protected function applyCashback($payload, $auth)
    {
        if ($auth) {
            $cashback = $auth->cashback_points;
            $total =  $payload['total'] - $cashback;

            if ($total < 0) {
                $amount = abs($total);
            } else {
                $amount = 0;
            }

            if ($total < 0) {
                $payload['cashback_used'] = $payload['total'];
                $payload['total'] = 0;
            } else {
                $payload['cashback_used'] = $cashback;
                $payload['total'] = $total;
            }

            $payload['cashback_points'] = $amount;
        }

        return $payload;
    }


    /**
     * Generates dynamic order code
     *
     * @return string
     */
    protected function getCode()
    {
        $order = $this->orderRepository
            ->getLatest()
            ->first();

        return sprintf("%u-%03d", $this->branch, !empty($order->id) ? $order->id + 1 : 1);
    }

    /**
     * Gets order products from the payload provided by
     * the client.
     *
     * @param array data
     * @return Illuminate\Support\Collection
     */
    protected function getOrderProducts($data)
    {
        $data['products'] = collect($data['products']);

        $productIds = ($data['products'])->pluck('id')->toArray();

        $products = $this->productService->whereIn([
            ['key' => 'id', 'values' => $productIds]
        ])->map(function ($product) use ($data) {
            $payloadProduct = $data['products']->where('id', '=', $product->id)->first();
            $arr = $this->setPayload($product, $payloadProduct);
            $arr['addons'] = $payloadProduct['addons'];
            return $arr;
        })->toArray();

        $data['orderProducts'] = $products;

        return $data;
    }

    /**
     * Gets order product addons annd order pricings
     * from the payload provided by the client
     *
     * @param array data
     * @return Illuminate\Support\Collection
     */
    protected function getOrderProductAddons($data)
    {
        foreach ($data['orderProducts'] as $key => $orderProduct) {
            $data['total'] += $orderProduct['total_price'];

            if (count($orderProduct['addons']) > 1) {
                $products = $this->productService->whereIn([
                    ['key' => 'id', 'values' => $orderProduct['addons']]
                ])->map(function ($addons) use ($orderProduct) {
                    $arr = $this->setPayload($addons, $orderProduct);
                    return $arr;
                })->toArray();

                $data['total'] += collect($products)->sum('total_price');

                $orderProduct['addons'] = $products;
            } else {
                $orderProduct['addons'] = [];
            }
            $data['orderProducts'][$key] = $orderProduct;
        }

        $data['sub_total'] = $data['total'];
        if (isset($data['discount'])) {
            $data['total'] = $data['total'] - $data['discount'];
        }

        return $data;
    }

    /**
     * Set dynamic payload according the fillable
     * array provided in the models
     *
     * @param object $data
     * @param array $payload
     * @return array $arr
     */
    protected function setPayload($data, $payload)
    {
        $arr = [];
        $arr['product_id'] = $data->id;
        $arr['category_id'] = $data->category_id;
        $arr['product_name'] = $data->name;
        $arr['quantity'] = $payload['quantity'];
        $arr['unit_price'] = $data->sale_price;
        $arr['stock_checking'] = $data->stock_checking;
        $arr['total_price'] = $data->sale_price * $payload['quantity'];

        return $arr;
    }

    /**
     * calculate discount for the current order being
     * inserted into the database (WIP)
     *
     * @param array $data
     * @return Illuminate\Support\Collection
     */
    protected function checkDiscount($data)
    {
        if ($data['discount_type']) {
            // calculate discount
        } else {
            return $data;
        }
    }

    /**
     * Check whether all the requested product
     * are in stock or not
     *
     * @param array $data
     * @return array
     */
    protected function checkStocks($payload)
    {
        foreach ($payload['orderProducts'] as $orderProduct) {
            $stock = $this->stock->getStockData(['product_id' => $orderProduct['product_id']]);
            if (($orderProduct['stock_checking']) && (!$stock->is_enabled || $stock->available_stock < $orderProduct['quantity'])) {
                return [
                    "status" => 0,
                    "message" => 'We are sorry ' . $orderProduct['product_name'] . ' is not available at this time. Please order something else'
                ];
            }

            foreach ($orderProduct['addons'] as $addon) {
                $stock = $this->stock->getStockData(['product_id' => $addon['product_id']]);
                if (($addon['stock_checking']) && (!$stock->is_enabled || $stock->available_stock < $addon['quantity'])) {
                    return [
                        "status" => 0,
                        "message" => 'We are sorry ' . $addon['product_name'] . ' is not available at this time. Please order something else'
                    ];
                }
            }
        }

        return $payload;
    }

    protected function applyStocks($data)
    {
        try {
            foreach ($data['orderProducts'] as $orderProduct) {
                $stock = $this->stock->getStockData(['product_id' => $orderProduct['product_id']]);

                if ($orderProduct['stock_checking']) {
                    $stock->available_stock = $stock->available_stock - $orderProduct['quantity'];
                    $this->stock->manageStock($stock);
                }

                foreach ($orderProduct['addons'] as $addon) {
                    $stock = $this->stock->getStockData(['product_id' => $addon['product_id']]);

                    if ($addon['stock_checking']) {
                        $stock->available_stock = $stock->available_stock - $addon['quantity'];
                        $this->stock->manageStock($stock);
                    }
                }
            }

            return true;
        } catch (Exception $e) {
            Log::info("stock update error " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all relevant information about the
     * required order.
     *
     * @param int id
     * @return \Modules\Order\app\Models\Order
     */
    public function orderData($id)
    {
        $order = $this->orderRepository->getById($id);
        $order = $this->orderProductService->getProductsByOrder($order);
        return $order;
    }

    public function getPendingOrders()
    {
        $orders = $this->orderRepository->getWhere(['created_at', '>=', date('Y-m-d')], ['status', '=', 'ongoing'])->get();
        if (count($orders) > 0) {
            $orders = $this->orderProductService->getProductsByOrder($orders);
        }
        return $orders;
    }

    public function getReadyOrders()
    {
        $orders = $this->orderRepository->getWhere(['created_at', '>=', date('Y-m-d')], ['status', '=', 'ready'])->get();
        if (count($orders) > 0) {
            $orders = $this->orderProductService->getProductsByOrder($orders);
        }
        return $orders;
    }

    public function getServeOrders()
    {
        $orders = $this->orderRepository->getWhere(['created_at', '>=', date('Y-m-d')], ['status', '=', 'served'])->get();
        if (count($orders) > 0) {
            $orders = $this->orderProductService->getProductsByOrder($orders);
        }
        return $orders;
    }

    public function getPendingAndReadyOrders()
    {
        $pendingOrders = $this->getPendingOrders()->toArray();
        $readyOrders = $this->getReadyOrders()->toArray();
        $orders = array_merge($pendingOrders, $readyOrders);
        return $orders;
    }


    public function getOrdersByDate($start, $end)
    {
        return $this->orderRepository->getWhere(['payment', '=', 'paid'], ['status', '=', 'served'], ['created_at', 'between', [$start, $end]])->get();
    }

    public function readyOrder($id)
    {
        $order = $this->orderRepository->getById($id);
        $order->status = 'ready';
        $order->ready_at = Carbon::now()->setTimezone('Asia/Singapore');
        $response = $this->orderRepository->save($order);

        if ($response) {
            $order = $this->orderProductService->getProductsByOrder($order);
            broadcast(new OrderReadyEvent($order->toJson(), $this->branch))->toOthers();
            return true;
        } else {
            return false;
        }
    }

    public function cancelOrder($data)
    {
        $order = $this->orderRepository->getById($data['id']);
        $order->status = 'cancelled';
        $order->cancelled_reason = 'Cancelled';
        $response = $this->orderRepository->save($order);

        if ($response) {
            $order = $this->orderProductService->getProductsByOrder($order);
            broadcast(new OrderCancelledEvent($order->toJson(), $this->branch))->toOthers();
            return true;
        } else {
            return false;
        }
    }

    public function serveOrder($data)
    {
        $order = $this->orderRepository->getById($data['id']);
        $order->status = 'served';
        $order->serve_at = Carbon::now()->setTimezone('Asia/Singapore');
        $response = $this->orderRepository->save($order);

        if ($response) {
            $order = $this->orderProductService->getProductsByOrder($order);
            broadcast(new OrderServedEvent($order->toJson(), $this->branch))->toOthers();
            return true;
        } else {
            return false;
        }
    }

    public function sendReminder($data)
    {
        $order = $this->orderRepository->getById($data['id']);

        if ($order) {
            $order = $this->orderProductService->getProductsByOrder($order);
            broadcast(new SendReadyOrderReminderEvent($order->toJson(), $this->branch))->toOthers();
            return true;
        } else {
            return false;
        }
    }
}
