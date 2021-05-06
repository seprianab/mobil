<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'user_id',
    ];

    public function sales(){
        return $this->hasMany('App\Models\Sale', 'customer_id', 'id');
    }
}
