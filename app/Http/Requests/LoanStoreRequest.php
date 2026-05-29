<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanStoreRequest extends FormRequest
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
            "employee_id" => "required",
            "contract_type_id" => "required",
            "loan_date" => "required",
            "first_payment_date" => "required",
            "total_loan_amount" => "required",
            "admin_fee" => "required",
            "received_amount" => "required",
            "notes" => "",
            "interest_amount_type" => "required",
            "interest_amount" => "required",
            "interest_amount_yearly" => "exclude_unless:interest_scheme_type_id,3|required|numeric|gt:0",
            "profit_company_ratio" => "required",
            "profit_employee_ratio" => "required",
            "interest_scheme_type_id" => "required",
            "total_pay_month" => "required",
            "pay_per_x_month" => "required",
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            "interest_amount_yearly.required" => "Suku Bunga / Tahun wajib diisi untuk skema perhitungan Anuitas.",
            "interest_amount_yearly.gt" => "Suku Bunga / Tahun harus lebih besar dari 0 untuk skema perhitungan Anuitas.",
        ];
    }
}
