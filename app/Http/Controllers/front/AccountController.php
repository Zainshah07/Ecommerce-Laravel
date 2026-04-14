<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Models\Order;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    protected $accountRepository;
    use ApiResponseTrait;

    public function __construct(AccountRepositoryInterface $accountRepository){
        $this->accountRepository= $accountRepository;
    }

    public function authenticate(Request $request){
        $credentials= $request->validate([
            'email'=>'required|email|exists:users',
            'password'=>'required'
        ]);

        $authUser=$this->accountRepository->authenticate($credentials);
        if(!$authUser){
            return $this->errorResponse('invalid fields');
        }
        return $this->successResponse($authUser, 'user verified successfully');
    }

    public function register(AccountRequest $request){
        $data=[
            'name' => $request->name,
            'email'=>$request->email,
            'password'=>$request->password,
            'role'=>'customer'
        ];
        $user = $this->accountRepository->register($data);

        return $this->successResponse($user, 'user registered successfully');

    }

    public function getOrderDetail($id, Request $request){
        $order = Order::where('user_id', $request->user()->id)->where('id', $id)->with(['items', 'items.product'])->first();
        if(!$order){
            return $this->errorResponse('order not found');
        }
        return $this->successResponse($order, 'order fetched successfully');
    }

    public function getOrders(Request $request){
        $orders = Order::where('user_id', $request->user()->id)->with('items')->get();
        return $this->successResponse($orders, 'orders fetched successfully');
    }

    public function updateProfile(Request $request){
        $user_id = $request->user()->id;
       $validator = Validator::make($request->all(), [
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'.$user_id,
            'address'=>'required',
            'city'=>'required',
            'state'=>'required',
            'zip'=>'required',
            'mobile'=>'required'
        ]);

      if($validator->fails()){
            return $this->errorResponse($validator->errors);
        }
      
        
        $userData = $this->accountRepository->updateProfile($user_id, $request->all());
        return $this->successResponse($userData, 'profile updated successfully');
    }

    public function getUserDetails(Request $request){
        $user_id = $request->user()->id;
        if(!$user_id){
            return $this->errorResponse('user not found');
        }
        $user = $this->accountRepository->getUserDetails($user_id);
        return $this->successResponse($user, 'user fetched successfully');
    }
}
