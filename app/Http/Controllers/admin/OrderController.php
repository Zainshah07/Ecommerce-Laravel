<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Traits\ApiResponseTrait;

class OrderController extends Controller
{
    protected $orderRepository;
    use ApiResponseTrait;


    public function __construct(OrderRepositoryInterface $orderRepository){
        $this->orderRepository = $orderRepository;
    }
    public function index(){
        $order = $this->orderRepository->index();
        if(!$order){
            return $this->errorResponse("No order found");
        }

        return $this->successResponse($order, "All orders fetched successfuly");
    }
    public function detail($id){
        $order = $this->orderRepository->detail($id);
        if(!$order){
            return $this->errorResponse("No order found");
        }

        return $this->successResponse($order, "order fetched successfuly");
    }
    public function update(Request $request, $id){
        $data = [
            'status' => $request->status,
            'payment_status' => $request->payment_status
        ];
        $order = $this->orderRepository->updateOrder($id, $data);
        if(!$order){
            return $this->errorResponse("No order found");
        }

        return $this->successResponse($order, "order updated successfuly");
    }
}
