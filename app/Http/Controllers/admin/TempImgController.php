<?php

namespace App\Http\Controllers\admin;


use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\TempImageRepositoryInterface;

class TempImgController extends Controller
{
    protected $productRepository;
    use ApiResponseTrait;

    public function __construct(TempImageRepositoryInterface $tempImageRepository) {
        $this->tempImageRepository = $tempImageRepository;
    }



    public function store(Request $request){

        $request->validate([
            'image'=>'required|file|mimes:jpg,jpeg,png|max:3048'
        ]);

        $tempImage= $this->tempImageRepository->store( ['name' => $request->file('image')]);
        return $this->successResponse($tempImage, 'Image stored successfully');
    }

        public function index(){
        $tempImages = $this->tempImageRepository->index();
        return $this->successResponse($tempImages, 'images fetched success');
    }
}
