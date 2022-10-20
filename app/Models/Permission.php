<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;
use DateTimeInterface;

class Permission extends SpatiePermission
{
    use HasFactory;

    protected $table = 'permissions';
    protected $fillable = [
        'id',
        'name',
        'guard_name',
    ];
    
    public static function defaultPermissions()
    {
        return [
            'view_dashboard',
            'view'
        ];
    }
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
