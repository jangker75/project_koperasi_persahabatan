<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransferStock extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'product_id', 'from_store_id', 'to_store_id',
      'send_qty', 'receive_qty', 'status_id', 'req_empl_id',
      'send_empl_id', 'order_date', 'send_date', 'received_date'
    ];



}
