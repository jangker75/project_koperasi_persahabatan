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
        'principal_savings_amount',
        'mandatory_savings_amount',
        'activity_savings_amount',
        'voluntary_savings_amount',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
