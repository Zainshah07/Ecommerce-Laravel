<?php
namespace App\Repositories\Contracts;

interface AccountRepositoryInterface{
    public function authenticate($credentials);
    public function register(array $data);
    public function updateProfile($id, array $data);
    public function getUserDetails($id);
}
