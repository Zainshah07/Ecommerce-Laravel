<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use app\Repositories\Contracts\OrderItemRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class OrderController extends Controller
{
    protected $orderRepository, $orderItemRepository;
    use ApiResponseTrait;

    public function __construct(OrderRepositoryInterface $orderRepository, OrderItemRepositoryInterface $orderItemRepository){
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
    }

    public function saveOrder(Request $request){

        if(!empty ($request->cart)){
              $details = [
            'name'=> $request->name,
            'email'=>$request->email,
            'address'=>$request->address,
            'mobile'=>$request->mobile,
            'state'=>$request->state,
            'zip'=>$request->zip,
            'city'=>$request->city,
            'grand_total'=>$request->grand_total,
            'sub_total'=>$request->sub_total,
            'discount'=>$request->discount,
            'shipping'=>$request->shipping,
            'status'=>$request->status,
            'payment_status'=>$request->payment_status,
            'payment_method'=> $request->payment_method,
            'user_id'=>$request->user()->id,
        ];
         $order = $this->orderRepository->saveOrder($details);

        foreach ($request->cart as $item) {
       $item_details = [
            'order_id'   => $order->id,
            'name'   => $item['title'],
            'product_id' => $item['product_id'],
            'quantity'        => $item['quantity'],
            'unit_price' => $item['price'],
            'size'       => $item['size'],
            'price'      => $item['quantity'] * $item['price']
        ];
         $orderItem = $this->orderItemRepository->saveItem($item_details);
     }

       
        }
        if (!$request->has('cart')) {
    return $this->errorResponse('Cart is missing');
        }

        return $this->successResponse($order, "order added successfuly");
    }

    public function createPayemntIntent(Request $request){
        try{
            
        if($request->amount>0){
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $payemntIntent = PaymentIntent::create([
                'amount' => $request->amount,
                'currency' => 'usd',
                'payment_method_types' => ['card']
            ]);
            $clientSecret = $payemntIntent->client_secret;
            return $this->successResponse($clientSecret, 'payment intent created');

        }
        else{
            return $this->errorResponse('invalid amount');
        }

        }
        catch(Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    
}
