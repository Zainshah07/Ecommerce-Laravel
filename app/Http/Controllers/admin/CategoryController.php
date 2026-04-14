<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Traits\ApiResponseTrait;

class CategoryController extends Controller
{
    protected $categoryRepository;
    use ApiResponseTrait;

    public function __construct(CategoryRepositoryInterface $categoryRepository){
        $this->categoryRepository = $categoryRepository;
    }

    public function index(){
       $categories = $this->categoryRepository->all();
       return $this->successResponse($categories, "All categories fetched successfuly");
    }

    public function store(CategoryRequest $request){
            $category = $this->categoryRepository->store($request->all());

           return $this->successResponse($category, "category added successfuly" ,201);
    }

    public function show($id){
        $category = $this->categoryRepository->find($id);
        if(!$category){
            return $this->errorResponse("No category found");
        }

        return $this->successResponse($category, "category fetched successfully");
    }

    public function update(CategoryRequest $request, $id){
        $category = $this->categoryRepository->update($id, $request->validated());

       if(!$category){
            return $this->errorResponse("No category found");
        }

        return $this->successResponse($category, "category updated successfully");
    }
    public function destroy($id){
        $category = $this->categoryRepository->delete($id);

         if(!$category){
            return $this->errorResponse("No category found");
        }

        return $this->successResponse($category,"category deleted successfully");

    }

    // for front-end apis

  
}
