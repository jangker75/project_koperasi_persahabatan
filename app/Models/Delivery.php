<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
      'order_id', 'other_fee', 'in_progress_datetime', 'delivery_datetime', 'delivered_datetime',
    ];
}
