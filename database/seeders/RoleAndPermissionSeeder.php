<?php

namespace Database\Seeders;

use App\Models\CmsMenu;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionList = ['read', 'create', 'update', 'delete'];
        //Seeder separator
        $separator = CmsMenu::where('isseparator', 1)->get('name');
        foreach ($separator as $item) {
            $name = str_replace(' ', '_', strtolower($item->name));
            foreach ($permissionList as $permission) {
                Permission::create([
                    'name' => $permission . ' ' . $name
                ]);
            }
        }

        //seeder permission every menu
        $cms = CmsMenu::whereNotNull('url')->get('url');

        foreach ($cms as $pathUrl) {
            $url = explode('/', $pathUrl->url);
            foreach ($permissionList as $permission) {
                Permission::create([
                    'name' => $permission . ' ' . $url[count($url) - 1]
                ]);
            }
        }

        //Create Role
        Role::create(['name' => 'superadmin']);
        $usipa = Role::create(['name' => 'usipa']);
        $toko = Role::create(['name' => 'toko']);
        $kasir = Role::create(['name' => 'kasir']);
        $manager = Role::create(['name' => 'manager']);
        $umum = Role::create(['name' => 'umum']);
        Role::create(['name' => 'nasabah']);

        $usipa->givePermissionTo([
            'read usipa', 'read loan-submission', 'read loan-list'
        ]);
        $toko->givePermissionTo([
            'read kelola_toko', 'read data-penjualan', 'read toko', 'read product',
            'read category', 'read supplier', 'read brand'
        ]);
        $kasir->givePermissionTo([
            'read kelola_toko'
        ]);
        $umum->givePermissionTo([
            'read divisi_umum',
            'read employee',
            'read ex-employee',
        ]);
    }
}
