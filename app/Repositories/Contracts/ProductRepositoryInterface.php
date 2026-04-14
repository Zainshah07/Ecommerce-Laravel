<?php

namespace App\Repositories\Contracts;

interface ProductRepositoryInterface {
    public function all();
    public function store(array $data);
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
    public function updateDefaultImage($id, $data);

    //frontend
    public function getProducts($filters);
    public function getProduct($id);
    public function latestProducts();
    public function featuredProducts();

}
