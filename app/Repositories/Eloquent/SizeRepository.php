<?php

namespace App\Repositories\Eloquent;

use App\Models\Size;
use App\Repositories\Contracts\SizeRepositoryInterface;

class SizeRepository implements SizeRepositoryInterface{
    protected $model;

    public function __construct(Size $size){
        $this->model = $size;
    }

    public function all(){
        return $this->model->orderBy('id','DESC')->get();
    }
}
