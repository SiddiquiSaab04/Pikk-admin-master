<?php

namespace Modules\Inventory\app\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        $categories = $this->groupBy('category.name')->toArray();
        $arr = [];
        $addons = [];

        foreach ($categories  as $key => $category) {
            foreach ($category as $resp) {
                $arr[$key] = [
                    "id" => $resp['id'],
                    "name" =>  $resp['name'],
                    "sku" =>  $resp['sku'],
                    "barcode" => $resp['barcode'],
                    "preview_url" => $resp['preview_url'],
                    "description" => $resp['description'],
                    "wholesale_price" => $resp['wholesale_price'],
                    "sale_price" => $resp['sale_price'],
                    "stock_checking" => $resp['stock_checking'],
                    "sort_order" => $resp['sort_order'],
                    "status" => $resp['status'],
                    "addons" => count($resp['addons']) > 1 ? collect($resp['addons'])->map(function ($addon) use ($addons, $key) {
                        $addons['id'] = $addon['id'];
                        $addons['name'] = $addon['modifier']['name'];
                        $addons['max_selection'] = $addon['max_selection'];
                        $addons['products'] = collect($addon['addon_products'])->map(fn ($product) => collect($product['product'])
                            ->except(['created_at', 'updated_at', 'category_id', 'addon_group_id']));
                        return $addons;
                    }) : [],
                ];
            }
        }

        return $arr;
    }
}
