<?php

namespace App\Models;

use App\Models\ProductSize;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'price',
        'compare_price',
        'description',
        'short_description',
        'image',
        'category_id',
        'brand_id',
        'is_featured',
        'quantity',
        'sku',
        'barcode',
        'status'
    ];

    protected $appends = ['image_url'];
    public function getImageUrlAttribute(){
        if($this->image == ""){
            return"";
        }
        return asset('storage/uploads/products/small/'.$this->image);
    }

    public function product_images(){
        return $this->hasMany(ProductImage::class);
    }
    public function product_sizes(){
        return $this->hasMany(ProductSize::class);
    }
}
