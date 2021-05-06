<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'date',

        'customer_id',
        'customer_name',
        'customer_phone',
        'customer_email',

        'car_id',
        'car_name',
        'car_price',
        'status',

        'user_id',
    ];

    protected $dates = [
        'date'
    ];

    public function getStatusTextAttribute(){
        $status = [
            1 => 'Active',
            2 => 'Cancelled',
        ];
        return $status[$this->attributes['status']];
    }

    public function car(){
        return $this->belongsTo('App\Models\Car', 'car_id', 'id');
    }
}
