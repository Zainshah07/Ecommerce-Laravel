<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Requests\BrandRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\BrandRepositoryInterface;

class BrandController extends Controller
{
    use ApiResponseTrait;
    protected $brandRepository;

    public function __construct(BrandRepositoryInterface $brandRepository){
        $this->brandRepository = $brandRepository;
    }

    public function index(){
        $brands = $this->brandRepository->all();
        return $this->successResponse($brands, 'all brands fetched');

    }

    public function show($id){
        $brand = $this->brandRepository->find($id);
        if(!$brand){
            return $this->errorResponse('Brand not found');
        }
        return $this->successResponse($brand, 'Success');
    }

    public function store(BrandRequest $request){
        $brand = $this->brandRepository->store($request->all());
         return $this->successResponse($brand, 'Success', 201);
    }

    public function update(BrandRequest $request, $id){
        $brand =  $this->brandRepository->update($id, $request->validated());
        if(!$brand){
            return $this->errorResponse('Brand not found');
        }
        return $this->successResponse($brand, 'Successfully updated brand');
    }

    public function destroy($id){
       $brand= $this->brandRepository->delete($id);

        return $this->successResponse($brand,'Successfully deleted brand');

    }
}
