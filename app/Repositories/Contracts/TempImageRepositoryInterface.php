<?php
namespace App\Repositories\Contracts;

interface TempImageRepositoryInterface {
    public function store(array $data);
    public function index();
    // public function update($id, array $data);
}
