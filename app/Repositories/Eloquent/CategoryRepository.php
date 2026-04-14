<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface{

    protected $model;

    public function __construct(Category $category){
        $this->model=$category;
    }

    public function all(){
        return $this->model->orderBy('created_at','DESC')->get();
    }

    public function store(array $data){
        return $this->model->create([
            'name'=>$data['name'],
            'status'=>$data['status'] ?? 1,
        ]);
    }

    public function find($id){
        return $this->model->findOrFail($id);
    }

    public function update($id, array $data){
        $category = $this->model->findOrFail($id);
        $category->update($data);
        return $category;
    }


    public function delete($id){
        $category = $this->model->findOrFail($id);
        $category->delete();
        return $category;
    }

    // for frontend

    public function getCategories(){
        $categories = $this->model->where('status',1)->orderBy('created_at', 'DESC')->get();
        return $categories;
    }

}
