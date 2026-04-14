<?php

namespace App\Repositories\Contracts;

interface ProductImageRepositoryInterface{
    public function storeImage($product_id, $image);
    public function deleteImage($product_id);
}


