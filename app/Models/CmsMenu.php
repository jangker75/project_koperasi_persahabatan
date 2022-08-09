<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsMenu extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','url', 'icon', 'order', 'main_menu_id','isseparator',
    ];
    public function subMenus()
    {
        return $this->hasMany(CmsMenu::class, 'main_menu_id');
    }
}
