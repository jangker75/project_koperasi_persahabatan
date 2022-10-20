<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\MasterDataStatus;
use App\Models\Position;
use App\Services\DynamicImageService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function update(EmployeeRequest $request, Employee $employee)
    {
        $input = $request->safe();
        // dd($input);
        // dd($employee);
        // dd($employee->user->profile_image);
        $employee->update($input->all());
        $imageService = (new DynamicImageService());
        //Save Image if there is update
        if ($request->hasFile('profile_image')) {
            ($employee->user->profile_image != null) 
            ? $imageService->delete($employee->user->profile_image) 
            : '';
            
            $data['profile_image'] = $imageService->uploadImage($request->file('profile_image'), config('constant.USER_IMAGE_PATH'));
            $employee->user->update($data);
         }
        // $role = checkPositionRole($employee->position->position_code);
        // $employee->user->syncRoles($role);
        return redirect()->route('nasabah.profile')->with('success', __('general.notif_edit_data_success'));
    }
    public function edit()
    {
        $data['positionList'] = Position::notAdmin()->pluck('name', 'id');
        $data['departmentList'] = Department::pluck('name', 'id');
        $data['statusEmployeeList'] = MasterDataStatus::statusEmployee()->pluck('name', 'id');
        $employee = auth()->user()->employee;
        $data['employee'] = $employee;
        return view('nasabah.pages.profile.form', $data);
    }
}
