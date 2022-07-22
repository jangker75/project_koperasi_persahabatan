<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "first_name" => 'required',
            "last_name" => 'required',
            "nik" => "required|unique:employees,nik,{$this->id},id,deleted_at,NULL",
            "nip" => '',
            "gender" => 'required',
            "position_id" => '',
            "department_id" => '',
            "status_employee_id" => 'required',
            "salary" => 'required',
            "birthday" => 'required',
            "address1" => '',
            "address2" => '',
            "phone" => '',
            "rekening" => 'required',
            "bank" => 'required',
        ];
    }
}
