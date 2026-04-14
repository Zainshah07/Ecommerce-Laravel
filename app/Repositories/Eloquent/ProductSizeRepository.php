<?php
namespace App\Repositories\Eloquent;

use App\Models\ProductSize;
use App\Repositories\Contracts\ProductSizeRepositoryInterface;

class ProductSizeRepository implements ProductSizeRepositoryInterface{
        protected $model;

        public function __construct(ProductSize $productSize){
            $this->model = $productSize;
        }

        public function storeSize($product_id,$sizes){

           foreach ($sizes as $sizeId) {
                $this->model->create([
                'product_id' => $product_id,
                'size_id'    => $sizeId
                ]);
            }

            return true;
        }
        public function updateSize($product_id,$sizes){
            $this->model->where('product_id', $product_id)->delete();
           foreach ($sizes as $sizeId) {
                $this->model->create([
                'product_id' => $product_id,
                'size_id'    => $sizeId
                ]);
            }

            return true;
        }
}
