<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SavingHistory extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'saving_id', 'saving_type', 'transaction_type','amount',
        'balance_before', 'balance_after', 'transaction_date',
    ];
    protected $hidden = [
        'deleted_at', 'created_at', 'updated_at'
    ];
    public function scopePrincipalSavingsBalance($query)
    {
        return $query->where('saving_type','principal_savings_balance');
    }
    public function scopeMandatorySavingsBalance($query)
    {
        return $query->where('saving_type','mandatory_savings_balance');
    }
    public function scopeActivitySavingsBalance($query)
    {
        return $query->where('saving_type','activity_savings_balance');
    }
    public function scopeVoluntarySavingsBalance($query)
    {
        return $query->where('saving_type','voluntary_savings_balance');
    }
}
