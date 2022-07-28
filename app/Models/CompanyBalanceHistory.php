<?php

namespace App\Models;

use App\Services\CompanyService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyBalanceHistory extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'balance_id', 'balance_type', 'transaction_type','description',
        'transaction_date','amount', 'balance_before', 'balance_after',
    ];
    public static function boot()
    {
        parent::boot();
        static::created(function($item){
            if($item->balance_type != 'total_balance'){
                (new CompanyService())
                ->addCreditBalance($item->amount, 'total_balance', $item->description);
            }
        });
    }
    public function scopeLoanBalance($query)
    {
        return $query->where('balance_type', 'loan_balance');
    }
    public function scopeOtherBalance($query)
    {
        return $query->where('balance_type', 'other_balance');
    }
    public function scopeTotalBalance($query)
    {
        return $query->where('balance_type', 'total_balance');
    }
    public function scopeStoreBalance($query)
    {
        return $query->where('balance_type', 'store_balance');
    }
}
