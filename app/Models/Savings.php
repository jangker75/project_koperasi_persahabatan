<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Savings extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'employee_id',
        'principal_savings_balance',
        'mandatory_savings_balance',
        'activity_savings_balance',
        'voluntary_savings_balance',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
    public function history()
    {
        return  $this->hasMany(SavingHistory::class, 'saving_id');
    }
}
