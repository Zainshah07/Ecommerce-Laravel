<?php

namespace  App\Repositories\Eloquent;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Contracts\AccountRepositoryInterface;

class AccountRepository implements AccountRepositoryInterface{
    protected $model;

    public function __construct(User $user){
        $this->model = $user;
    }

    public function authenticate($credentials){
        $user= $this->model->where('email',$credentials['email'])->first();
         if ($user && Hash::check($credentials['password'], $user->password)) {
            $token = $user->createToken('token')->plainTextToken;
            return [
                'user' => $user,
                'token' => $token
            ];

    }
     return null;
}

    public function register(array $data){
        $user = $this->model->create([
            'name'=> $data['name'],
            'email'=>$data['email'],
            'password'=> bcrypt($data['password']),
            'role'=>$data['role']
        ]);


        return $user;

    }
    public function updateProfile( $id, array $data){
        $user = $this->model->findOrFail($id);
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->address = $data['address'];
        $user->city = $data['city'];
        $user->state = $data['state'];
        $user->zip = $data['zip'];
        $user->mobile = $data['mobile'];
        $user->save();
        return $user;
    }
    public function getUserDetails($id){
        return $this->model->findOrFail($id);
    }

}
