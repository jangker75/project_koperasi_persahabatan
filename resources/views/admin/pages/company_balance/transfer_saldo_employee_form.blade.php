<x-admin-layout>
    @include('nasabah.shared.form_error')
    <a href="{{ $currentIndex }}" type="button" class="btn btn-danger mb-3">{{ __('general.button_cancel') }}</a>
    <div class="row">
        <div class="card">
            {!! Form::open(['route' => 'admin.company-balance.transfer-saldo-employee.store', 'files' => true, 'class' => 'form-horizontal']) !!}
            @csrf
            <div class="card-header">
                <h4 class="card-title">{{ $titlePage }}</h4>
            </div>
            
            <div class="card-body">
                <div class="row mb-4">
                    {!! Form::label('employee_id', __('balance_company.employee_id'), ['class' => 'col-md-3 form-label required']) !!}
                    <div class="col-md-4">
                        {!! Form::select('employee_id', $employeeList, null, [
                            'required' => 'required',
                            'id' => 'employee_id',
                            'class' =>
                                'form-control form-select select2' .
                                ($errors->has('employee_id') ? ' is-invalid' : '') .
                                (!$errors->has('employee_id') && old('employee_id') ? ' is-valid' : ''),
                            'placeholder' => 'Input ' . __('balance_company.employee_id'),
                        ]) !!}
                    </div>
                </div>
                <div class="row mb-4">
                    {!! Form::label('employee_savings_type', __('balance_company.employee_savings_type'), ['class' => 'col-md-3 form-label required']) !!}
                    
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-xl-3">
                                <div class="customer-services mb-2">
                                    <label class="custom-control custom-radio-md">
                                        {!! Form::radio("employee_savings_type", "principal_savings_balance", false, [
                                        "class" => 'custom-control-input',
                                        "id" => "principal_savings_balance_radio",
                                        "disabled" => false,
                                        ]) !!}
                                    <span class="custom-control-label">
                                        <div class="icon-content">
                                            <span><i class="bi bi-truck"></i></span>
                                            <h4>{{ __('savings_employee.principal_savings_balance') }}</h4>
                                        </div>
                                    </span>
                                    </label>
                                    <p id="principal_savings_balance_value">Rp. 0</p>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="customer-services mb-2">
                                    <label class="custom-control custom-radio-md">
                                        {!! Form::radio("employee_savings_type", "activity_savings_balance", false, [
                                        "class" => 'custom-control-input',
                                        "id" => "activity_savings_balance_radio",
                                        "disabled" => false,
                                        ]) !!}
                                    <span class="custom-control-label">
                                        <div class="icon-content">
                                            <span><i class="bi bi-truck"></i></span>
                                            <h4>{{ __('savings_employee.activity_savings_balance') }}</h4>
                                        </div>
                                    </span>
                                    </label>
                                    <p id="activity_savings_balance_value">Rp. 0</p>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="customer-services mb-2">
                                    <label class="custom-control custom-radio-md">
                                        {!! Form::radio("employee_savings_type", "mandatory_savings_balance", false, [
                                        "class" => 'custom-control-input',
                                        "id" => "mandatory_savings_balance_radio",
                                        "disabled" => false,
                                        ]) !!}
                                    <span class="custom-control-label">
                                        <div class="icon-content">
                                            <span><i class="bi bi-truck"></i></span>
                                            <h4>{{ __('savings_employee.mandatory_savings_balance') }}</h4>
                                        </div>
                                    </span>
                                    </label>
                                    <p id="mandatory_savings_balance_value">Rp. 0</p>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="customer-services mb-2">
                                    <label class="custom-control custom-radio-md">
                                        {!! Form::radio("employee_savings_type", "voluntary_savings_balance", false, [
                                        "class" => 'custom-control-input',
                                        "id" => "voluntary_savings_balance_radio",
                                        "disabled" => false,
                                        ]) !!}
                                    <span class="custom-control-label">
                                        <div class="icon-content">
                                            <span><i class="bi bi-truck"></i></span>
                                            <h4>{{ __('savings_employee.voluntary_savings_balance') }}</h4>
                                        </div>
                                    </span>
                                    </label>
                                    <p id="voluntary_savings_balance_value">Rp. 0</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    {!! Form::label('company_balance', "Saldo Koperasi", ['class' => 'col-md-3 form-label required']) !!}
                    <div class="col-md-4">
                        {!! Form::select('company_balance', \App\Enums\ConstantEnum::BALANCE_COMPANY, null, [
                            'required' => 'required',
                            'class' =>
                                'form-control form-select' .
                                ($errors->has('company_balance') ? ' is-invalid' : '') .
                                (!$errors->has('company_balance') && old('company_balance') ? ' is-valid' : ''),
                            'placeholder' => 'Input ' . __('balance_company.destination_balance'),
                        ]) !!}
                    </div>
                </div>
                <div class="row mb-4">
                    {!! Form::label('amount', __('balance_company.amount'), ['class' => 'col-md-3 form-label required']) !!}
                    <div class="col-md-6">
                        {!! Form::text('amount', null, [
                            'required' => 'required',
                            'class' =>
                                'form-control' .
                                ($errors->has('amount') ? ' is-invalid' : '') .
                                (!$errors->has('amount') && old('amount') ? ' is-valid' : ''),
                            'placeholder' => 'Input ' . __('balance_company.amount'),
                        ]) !!}
                    </div>
                </div>
                <div class="row mb-4">
                    {!! Form::label('description', __('balance_company.description'), ['class' => 'col-md-3 form-label']) !!}
                    <div class="col-md-6">
                        {!! Form::textarea('description', null, [
                            'rows' => 4,
                            'class' =>
                                'form-control' .
                                ($errors->has('description') ? ' is-invalid' : '') .
                                (!$errors->has('description') && old('description') ? ' is-valid' : ''),
                            'placeholder' => 'Input ' . __('balance_company.description'),
                        ]) !!}
                </div>
            </div>
            <div class="card-footer">
                <a class="btn btn-danger" href="{{ $currentIndex }}">{{ __('general.button_cancel') }}</a>
                <button class="btn btn-success">{{ __('general.button_save') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    @slot('script')
        <script>
            $("#employee_id").on('change', function(){
                console.log("test");
                let employeeId = $(this).find(":selected").val()
                getDataSavings(employeeId)
            })
            function getDataSavings(employeeId){
                $.ajax({
                    type: "get",
                    url: "{{ url('admin/employee-balance-information') }}/"+employeeId,
                    dataType: "json",
                    success: function (response) {
                        setDataSavings(response)
                    }
                });
            }
            function setDataSavings(data){
                $("#mandatory_savings_balance_radio").attr("disabled", false)
                $("#principal_savings_balance_radio").attr("disabled", false)
                $("#voluntary_savings_balance_radio").attr("disabled", false)
                $("#activity_savings_balance_radio").attr("disabled", false)
                
                $("#mandatory_savings_balance_value").html(data["mandatory_savings_balance"])
                $("#principal_savings_balance_value").html(data["principal_savings_balance"])
                $("#voluntary_savings_balance_value").html(data["voluntary_savings_balance"])
                $("#activity_savings_balance_value").html(data["activity_savings_balance"])
                
                if(data["mandatory_savings_balance_value"] == 0){
                    $("#mandatory_savings_balance_radio").attr("disabled", true)
                }
                if(data["voluntary_savings_balance_value"] == 0){
                    $("#voluntary_savings_balance_radio").attr("disabled", true)
                }
                if(data["principal_savings_balance_value"] == 0){
                    $("#principal_savings_balance_radio").attr("disabled", true)
                }
                if(data["activity_savings_balance_value"] == 0){
                    $("#activity_savings_balance_radio").attr("disabled", true)
                }
            }
        </script>
    @endslot
</x-admin-layout>