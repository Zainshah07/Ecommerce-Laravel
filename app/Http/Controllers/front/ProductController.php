<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class ProductController extends Controller
{
    protected $productRepository;
    use ApiResponseTrait;

    public function __construct(ProductRepositoryInterface $productRepository, CategoryRepositoryInterface $categoryRepository, BrandRepositoryInterface $brandRepository){
        $this->productRepository= $productRepository;
        $this->categoryRepository= $categoryRepository;
        $this->brandRepository= $brandRepository;
    }

    public function latestProducts(){
        $latestProducts = $this->productRepository->latestProducts();
        return $this->successResponse($latestProducts, 'Latest Products');
    }
    public function featuredProducts(){
        $latestProducts = $this->productRepository->featuredProducts();
        return $this->successResponse($latestProducts, 'Featured Products');
    }

      public function getCategories(){
        $categories= $this->categoryRepository->getCategories();
        return $this->successResponse($categories, 'Categories fetched');
    }
      public function getBrands(){
        $brands= $this->brandRepository->getBrands();
        return $this->successResponse($brands, 'Brands fetched');
    }

    public function getProducts(Request $request){
        $filters=[
            'category'=>$request->category,
            'brand'=> $request->brand,
        ];
    $products = $this->productRepository->getProducts($filters);

    return $this->successResponse($products, 'Filtered Products Loaded');
    }

    public function getProduct($id){
        $product= $this->productRepository->getProduct($id);
        if($product == null){
            return $this->errorResponse('product not found');
        }
        return $this->successResponse($product, 'Product fetched');
    }
}


