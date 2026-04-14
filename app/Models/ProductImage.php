<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable=[
        'image',
        'product_id'
    ];

     protected $appends = ['image_url'];
    public function getImageUrlAttribute(){
        if($this->image == ""){
            return"";
        }
        return asset('storage/uploads/products/small/'.$this->image);
    }
}
