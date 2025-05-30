<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'position_code'];

    public function Employee(){
      return $this->hasMany(Employee::class);
    }
    public function scopeNotAdmin($query)
    {
      return $query->where('id', '!=', 1);
    }
}
