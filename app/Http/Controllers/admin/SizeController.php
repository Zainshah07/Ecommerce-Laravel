<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\SizeRepositoryInterface;

class SizeController extends Controller
{
    protected $sizeRepository;
    use ApiResponseTrait;

    public function __construct(SizeRepositoryInterface $sizeRepository){
        $this->sizeRepository = $sizeRepository;
    }

    public function index(){
        $sizes = $this->sizeRepository->all();
        return $this->successResponse($sizes,'All sizes fetched successfuly');
    }
}
