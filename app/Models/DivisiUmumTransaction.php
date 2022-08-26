<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DivisiUmumTransaction extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'transaction_type', 'user_id', 'amount', 'transaction_date', 'description',
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id','user_id');
    }
}
