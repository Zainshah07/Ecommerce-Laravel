<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contracts\ShippingRepositoryInterface;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Validator;


class ShippingController extends Controller
{
    use ApiResponseTrait;
    protected $shippingRepository;

    public function __construct(ShippingRepositoryInterface $shippingRepository){
        $this->shippingRepository = $shippingRepository;
    }


    public function getShippingCharges(){
        $shipping = $this->shippingRepository->getShippingCharges();
        return $this->successResponse($shipping, 'shipping charges fetched successfully');
    }
    public function updateShippingCharges(Request $request){
        $validator = Validator::make($request->all(), [
            'shipping_charges'=>'required'
        ]);
        if($validator->fails()){
            return $this->errorResponse($validator->errors);
        }
        $shipping = $this->shippingRepository->updateShippingCharges($request->all());
        return $this->successResponse($shipping, 'shipping charges updated successfully');
    }
    
}
