<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpParser\Node\Expr\Cast\String_;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'user_id', 'first_name', 'last_name',
      'birthday', 'address_1', 'address_2',
      'nik', 'nip', 'gender', 'bank', 'rekening',
      'registered_date', 'resign_date','departement_id',
      'position_id', 'status_employee_id','salary'
    ];

    public function user(){
      return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function departement(){
      return $this->belongsTo(Departement::class, 'departement_id');
    }
    
    public function position(){
      return $this->belongsTo(Position::class, 'position_id');
    }

    public function statusEmployee(){
      return $this->belongsTo(MasterDataStatus::class, 'status_employee_id');
    }
    public function getFullNameAttribute()
    {
      return $this->first_name . $this->last_name;
    }
}
