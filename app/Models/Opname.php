<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Opname extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'store_id', 'is_commit', 'note', 'employee_id', 'total_price'
    ];

    public function employee(){
      return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function store(){
      return $this->belongsTo(Store::class, 'store_id');
    }

    public function detail(){
      return $this->hasMany(OpnameDetail::class, 'opname_id', 'id');
    }
}
