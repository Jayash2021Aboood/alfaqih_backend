<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'user_name',
        'national_id',
        'amount',
        'car_id',
        'car_company',
        'car_model',
        'car_color',
        'car_base_number',
        'invoice_file',
    ];

    

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function car() {
        return $this->belongsTo(Car::class);
    }

}
