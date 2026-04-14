<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface{
    protected $model;

    public function __construct(Order $order){
        $this->model = $order;
    }

    public function saveOrder(array $details){
       $order= $this->model->create([
        'name'=>$details['name'],
        'email'=>$details['email'],
        'address'=>$details["address"],
        'mobile'=>$details["mobile"],
        'state'=>$details["state"],
        'zip'=>$details["zip"],
        'city'=>$details["city"],
        'grand_total'=>$details["grand_total"],
        'sub_total'=>$details["sub_total"],
        'discount'=>$details["discount"],
        'shipping'=>$details["shipping"],
        'status'=>$details["status"],
        'payment_status'=>$details["payment_status"],
        'payment_method'=>$details["payment_method"],
        'user_id'=>$details["user_id"],
       ]);
       return $order;
    }

    public function index(){
        return $this->model->orderBy('created_at','DESC')->get();
    }

    public function detail($id){
        return $this->model->with(['items','items.product'])->findOrFail($id);
    }

    public function updateOrder($id, $data){
        $order = $this->model->findOrFail($id);
        $order->status = $data['status'];
        $order->payment_status = $data['payment_status'];
        $order->update();
        return $order;
    }
}
