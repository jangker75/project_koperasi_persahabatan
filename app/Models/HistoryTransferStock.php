<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryTransferStock extends Model
{
    use HasFactory;

    protected $fillable = ['transfer_stock_id', 'title', 'status'];
}
