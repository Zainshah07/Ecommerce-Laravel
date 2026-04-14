<?php

namespace App\Repositories\Contracts;


interface CategoryRepositoryInterface{

    public function all();
    public function store(array $data);
    public function find($id);
    public function update($id, array $data);
    public function delete($id);

    // for frontend

    public function getCategories();


}
