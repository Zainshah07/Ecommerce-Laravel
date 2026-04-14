<?php
namespace App\Repositories\Eloquent;

use App\Models\ShippingCharge;
use App\Repositories\Contracts\ShippingRepositoryInterface;

class ShippingRepository implements ShippingRepositoryInterface{
    protected $model;

    public function __construct(ShippingCharge $model){
        $this->model = $model;
    }

    public function getShippingCharges(){
        return $this->model->first();
    }
    public function updateShippingCharges(array $data){
        $shipping = $this->model->first();

        if(!$shipping){
            $shipping = $this->model->create([
                'shipping_charges'=> $data['shipping_charges']
            ]);
            $shipping->save();

        }else{
            $shipping->shipping_charges = $data['shipping_charges'];
            $shipping->update();
        }
        return $shipping;
        
    }
}
