<?php

namespace App\Models;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];
    protected function casts(){
        return [
            'created_at'=> 'datetime:d M, Y'
        ];
    }

    public function items(){
        return $this->hasMany(OrderItem::class);
    
    }
}
