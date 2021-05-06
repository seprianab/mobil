<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'stock',
        'user_id',
    ];

    public function sales(){
        return $this->hasMany('App\Models\Sale', 'car_id', 'id');
    }
}
