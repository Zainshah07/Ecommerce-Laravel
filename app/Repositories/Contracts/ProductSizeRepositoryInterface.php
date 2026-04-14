<?php

namespace App\Repositories\Contracts;

interface ProductSizeRepositoryInterface{
    public function updateSize($product_id, $sizes);
    public function storeSize($product_id, $sizes);
}


