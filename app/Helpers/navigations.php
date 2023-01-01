<?php

use App\Models\CmsMenu;

if (!function_exists('getMenus')) {
    function getMenus()
    {
        $menus = CmsMenu::with('subMenus')
        ->whereNull('main_menu_id')->get();
        return $menus;
        
    }
}
