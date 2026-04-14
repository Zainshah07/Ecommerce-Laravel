<?php
namespace App\Repositories\Contracts;

interface OrderRepositoryInterface{
    public function saveOrder(array $details);
    public function index();
    public function detail($id);
    public function updateOrder($id, $data);
}
