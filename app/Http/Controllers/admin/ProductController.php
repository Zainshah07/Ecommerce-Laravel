<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Repositories\Eloquent\ProductSizeRepository;
use App\Repositories\Eloquent\ProductImageRepository;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductController extends Controller
{
    protected $productRepository;
    protected $productImageRepository;
    use ApiResponseTrait;

    public function __construct(ProductRepositoryInterface $productRepository, ProductImageRepository $productImageRepository,  ProductSizeRepository $productSizeRepository){
        $this->productRepository = $productRepository;
        $this->productSizeRepository = $productSizeRepository;
        $this->productImageRepository = $productImageRepository;
    }

    public function index(){
        $products = $this->productRepository->all();
        return $this->successResponse($products, "products fetched successfuly");
    }

    public function show($id){
        $product = $this->productRepository->find($id);
        if(!$product){
            return $this->errorResponse('no product found');
        }
        return $this->successResponse($product, 'product fetched successfuly');
    }

    public function store(ProductRequest $request){
        $product = $this->productRepository->store($request->all());
        if ($request->has('sizes') && !empty($request->sizes)) {
        $this->productSizeRepository->storeSize($product->id, $request->sizes);
        }
         return $this->successResponse($product, 'product stored successfuly');

    }

    public function update($id, ProductRequest $request){
        $product = $this->productRepository->update($id, $request->validated());

        if(!$product){
            return $this->errorResponse('no product found');
        }

        if ($request->has('sizes') && !empty($request->sizes)) {
        $this->productSizeRepository->updateSize($id, $request->sizes);
    }
        return $this->successResponse($product, 'product updated successfuly');
    }

    public function updateDefaultImage(Request $request){

    $defaultImage = $this->productRepository->updateDefaultImage(
        $request->product_id,
        $request->image
    );
         return $this->successResponse('image set as default');
    }

    public function destroy($id){
        $product = $this->productRepository->delete($id);
        
        return $this->successResponse($product, 'product deleted successfuly');
    }

    public function storeImage(Request $request){

    $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        'product_id'=>'exists:products,id'
    ]);



        // if(!$product){
        //     return $this->errorResponse('No product found');
        // }


    $image = $request->file('image');
    $product_id= $request->product_id;

    $productImage = $this->productImageRepository->storeImage($product_id, $image);

    return $this->successResponse($productImage, 'Product image updated successfully');
}

public function deleteImage($product_id){
    $product_image = $this->productImageRepository->deleteImage($product_id);
    return $this->successResponse($product_image,'image deleted successfuly');
}

}
