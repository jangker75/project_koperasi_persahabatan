<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterDataStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'type'];

    public function scopeStatusEmployee($query)
    {
        return $query->where('type', 'status_employee');
    }
}
