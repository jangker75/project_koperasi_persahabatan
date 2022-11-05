<x-admin-layout>
    @include('nasabah.shared.form_error')
    <a href="{{ $currentIndex }}" type="button" class="btn btn-danger mb-3">{{ __('general.button_cancel') }}</a>
    <div class="row">
        <div class="card">
            {!! Form::open(['route' => 'admin.company-balance.transfer-simp-sukarela.store', 'files' => true, 'class' => 'form-horizontal']) !!}
            @csrf
            <div class="card-header">
                <h4 class="card-title">{{ $titlePage }}</h4>
            </div>
            
            <div class="card-body">
                <div class="row mb-4">
                    {!! Form::label('transaction_type', "Tipe Transaksi", ['class' => 'col-md-3 form-label required']) !!}
                    <div class="col-md-4">
                        {!! Form::select('transaction_type', $transactionType, null, [
                            'required' => 'required',
                            'id' => 'transaction_type',
                            'class' =>
                                'form-control form-select' .
                                ($errors->has('transaction_type') ? ' is-invalid' : '') .
                                (!$errors->has('transaction_type') && old('transaction_type') ? ' is-valid' : ''),
                        ]) !!}
                    </div>
                </div>
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
                    {!! Form::label('employee_savings_type', __('balance_company.employee_savings_type'), ['class' => 'col-md-3 form-label']) !!}
                    
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="row">
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
                                    <input type="hidden" value="0" id="voluntary_savings_balance_value_input">
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
                    {!! Form::label('amount', __("Jumlah Simpan/tarik"), ['class' => 'col-md-3 form-label required']) !!}
                    <div class="col-md-6">
                        {!! Form::text('amount', null, [
                            'required' => 'required',
                            'class' =>
                                'form-control' .
                                ($errors->has('amount') ? ' is-invalid' : '') .
                                (!$errors->has('amount') && old('amount') ? ' is-valid' : ''),
                            'placeholder' => 'Input Jumlah Simpan/tarik',
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
                <button id="btnSave" class="btn btn-success">{{ __('general.button_save') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    @slot('script')
    <script>
            $(document).ready(function(){
                $("#voluntary_savings_balance_radio").attr("disabled", true)
                $("#voluntary_savings_balance_radio").attr("checked", "checked")
            })
            $("#employee_id").on('change', function(){
                let employeeId = $(this).find(":selected").val()
                getDataSavings(employeeId)
            })
            $("#transaction_type").on('change', function(){
                checkVoluntaryValue()
            })

            function getDataSavings(employeeId){
                $.ajax({
                    type: "get",
                    url: "{{ url('admin/employee-balance-information') }}/"+employeeId,
                    dataType: "json",
                    success: function (response) {
                        setDataSavings(response)
                    },
                    complete : function(){
                        checkVoluntaryValue()
                    }
                });
            }
            function setDataSavings(data){
                console.log(data);
                $("#voluntary_savings_balance_value").html(data["voluntary_savings_balance"])
                $("#voluntary_savings_balance_value_input").val(data["voluntary_savings_balance_value"])
            }
            function checkVoluntaryValue(){
                let transactionType = $('#transaction_type').find(":selected").val()
                let voluntaryValue = $("#voluntary_savings_balance_value_input").val()
                console.log("transaction_type",transactionType);
                console.log("voluntaryValue",voluntaryValue);
                if(transactionType == 'debit' && voluntaryValue <= 0) {
                    $("#btnSave").prop('disabled', true)
                }else{
                    $("#btnSave").prop('disabled', false)
                }
            }
        </script>
    @endslot
</x-admin-layout>