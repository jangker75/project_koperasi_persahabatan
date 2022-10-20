<?php

namespace App\Http\Controllers;

use App\Models\ApplicationSetting;
use Illuminate\Http\Request;

class ApplicationSettingController extends BaseAdminController
{
    public function __construct()
    {   
        parent::__construct();
        $this->data['currentIndex'] = route('admin.app-setting.index');
    }
    public function index()
    {
        $data = $this->data;
        $data["titlePage"] = "Setting Application Page";
        $data["subtitlePage"] = "";
        $data["appsetting"] = ApplicationSetting::latest()->get();
        return view('admin.pages.application_setting.index', $data);
    }
    public function update(Request $request)
    {
        $input = $request->all();
        unset($input['_token']);
        foreach ($input as $key => $value) {
            ApplicationSetting::where('name', $key)->update(['content' => $value]);
        }
        return redirect()->route('admin.app-setting.index')->with('success', __('general.notif_edit_data_success'));
    }
}
