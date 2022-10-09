<?php

namespace App\Http\Controllers;

use App\Models\CmsMenu;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleManagementController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['currentIndex'] = route('admin.role-management.index');
    }
    public function index()
    {
        $data = $this->data;
        $data['titlePage'] = 'Role Management';
        $data['roles'] = Role::with('permissions')->get();
        
        return view('admin.pages.role-management.index', $data);
    }

    public function edit(Role $role_management)
    {
        $data = $this->data;
        $data['titlePage'] = 'Edit';
        $data['role'] = $role_management;
        $data['roleList'] = Role::pluck('name','id');
        $data['permissionList']= Permission::get();
        $data['menuList'] = CmsMenu::with('subMenus')->get();
        return view('admin.pages.role-management.form', $data);
    }
    public function update(Request $request, Role $role_management)
    {
        $input = $request->except(['name','_token', '_method']);
        $perm = [];
        foreach ($input as $key => $value) {
            $a = explode("_",$key);
            $res = str_replace($a[0]."_", $a[0]." ", $key);
            array_push($perm, $res);
        }
        // dd($perm);
        $role_management->syncPermissions($perm);
        return redirect()->route('admin.role-management.index')->with('success', __('general.notif_edit_data_success'));
    }
}
