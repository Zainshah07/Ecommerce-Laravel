<?php
namespace App\Repositories\Eloquent;

use App\Models\Brand;
use App\Repositories\Eloquent\BrandRepository;
use App\Repositories\Contracts\BrandRepositoryInterface;

class BrandRepository implements BrandRepositoryInterface{

    protected $model;

    public function __construct(Brand $brand){
        $this->model = $brand;
    }

    public function all(){
        return $this->model->orderBy('created_at','DESC')->get();
    }

    public function find($id){
        return $this->model->findOrFail($id);
    }
    public function store(array $data){
        return $this->model->create([
            'name'=>$data['name'],
            'status'=>$data['status'] ?? 1
        ]);
    }
    public function update($id, array $data){
        $brand = $this->model->findOrFail($id);
        $brand->update($data);
        return $brand;
    }
    public function delete($id){
        $brand = $this->model->findOrFail($id);
        $brand->delete();
        return $brand;
    }

    // frontend

    public function getBrands(){
        $brands= $this->model->orderBy('created_at','DESC')->where('status',1)->get();
        return $brands;
    }
}
