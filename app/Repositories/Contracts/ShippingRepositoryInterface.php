<?php
namespace App\Repositories\Contracts;

interface ShippingRepositoryInterface{
    public function getShippingCharges();
    public function updateShippingCharges(array $data);

}