<?php
namespace App\Repositories\Eloquent;

use App\Models\OrderItem;
use App\Repositories\Contracts\OrderItemRepositoryInterface;

class OrderItemRepository implements OrderItemRepositoryInterface{
    protected $model;

    public function __construct(OrderItem $orderItem){
        $this->model = $orderItem;
    }
    public function saveItem($data){

        return $this->model->create([
            'order_id'=>$data['order_id'],
            'name'=>$data['name'],
            'product_id' => $data['product_id'],
            'quantity'        => $data['quantity'],
            'unit_price' => $data['unit_price'],
            'price'      => $data['price'],
            'size'      => $data['size'],
        ]);
    }

}
