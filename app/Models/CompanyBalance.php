<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyBalance extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'company_id', 'loan_balance', 'store_balance',
        'other_balance', 'total_balance',
    ];
    
}
