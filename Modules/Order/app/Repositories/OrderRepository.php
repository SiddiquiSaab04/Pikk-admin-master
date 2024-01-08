<?php

namespace Modules\Order\app\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Order\app\Interfaces\OrderInterface;
use Modules\Order\app\Models\Order;

class OrderRepository implements OrderInterface
{
    protected $query;

    public function initTable($model, $table)
    {
        $this->query = new $model;
        $this->query->setTableName($table);
        return $this;
    }

    public function create($data)
    {
        return $this->query->create($data);
    }

    public function delete($id)
    {
        return $this->query->where('id', $id)->delete();
    }

    public function update($id, $data)
    {
        return $this->query->find($id)->update($data);
    }

    public function getAll()
    {
        return $this->query->orderByDesc('created_at');
    }

    public function getById($id)
    {
        return $this->query->find($id);
    }

    public function getWhere()
    {
        $clause = func_get_args();
        return $this->query->where(function ($query) use ($clause) {
            foreach ($clause as $statement) {
                [$key, $operator, $value] = $statement;
                if ($key == 'created_at') {
                    if ($operator == 'between') {
                        $query->whereBetween($key, $value);
                    } else {
                        $query->whereDate($key, $operator, $value);
                    }
                } else {
                    $query->where($key, $operator, $value);
                }
            }
        });
    }

    public function whereIn()
    {
        $clause = func_get_args();
        return $this->query->where(function ($query) use ($clause) {
            foreach ($clause as $statement) {
                [$key, $value] = $statement;
                $query->whereIn($key, $value);
            }
        });
    }

    public function getLatest()
    {
        return $this->query->latest();
    }

    public function paginate($number)
    {
        return $this->query->paginate(20);
    }

    public function get()
    {
        return $this->query->get();
    }

    public function first()
    {
        return $this->query->first();
    }

    public function dd()
    {
        return $this->query->dd();
    }

    public function save($order)
    {
        return $order->save();
    }
}
