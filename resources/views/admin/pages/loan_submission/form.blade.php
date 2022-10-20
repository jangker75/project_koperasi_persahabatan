<x-admin-layout>
    @include('nasabah.shared.form_error')
    <a href="{{ $currentIndex }}" type="button" class="btn btn-danger mb-3">{{ __('general.button_cancel') }}</a>
    <div class="alert alert-danger" role="alert" id="status-loan-employee"></div>
    <div class="alert alert-danger" role="alert" id="status-age-employee"></div>
    <div class="row">
        <div class="col-lg-12">
            @if (isset($loan))
                {!! Form::model($loan, [
                    'route' => ['admin.loan-submission.update', $loan],
                    'method' => 'PUT',
                    'files' => true,
                ]) !!}
                {!! Form::hidden('id') !!}
            @else
                {!! Form::open(['route' => 'admin.loan-submission.store', 'files' => true, 'class' => 'form-horizontal']) !!}
            @endif
            @csrf
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $titlePage }}</h4>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        {!! Form::label('employee_id', __('employee.name'), ['class' => 'col-md-3 form-label required']) !!}
                        <div class="col-md-9">
                            {!! Form::select('employee_id', $employeeList, null, [
                                'required' => 'required',
                                'id' => 'employee_id',
                                'class' =>
                                    'form-control form-select select2' .
                                    ($errors->has('employee_id') ? ' is-invalid' : '') .
                                    (!$errors->has('employee_id') && old('employee_id') ? ' is-valid' : ''),
                                'placeholder' => 'Input ' . __('employee.name'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="row mb-4">
                        {!! Form::label('contract_type_id', __('loan.contract_type_id'), ['class' => 'col-md-3 form-label required']) !!}
                        <div class="col-md-9">
                            {!! Form::select('contract_type_id', $contractTypeList, null, [
                                'required' => 'required',
                                'class' =>
                                    'form-control form-select select2' .
                                    ($errors->has('contract_type_id') ? ' is-invalid' : '') .
                                    (!$errors->has('contract_type_id') && old('contract_type_id') ? ' is-valid' : ''),
                                'placeholder' => 'Input ' . __('loan.contract_type_id'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="row mb-4">
                        {!! Form::label('loan_date', __('loan.loan_date'), ['class' => 'col-md-3 form-label required']) !!}
                        <div class="col-md-9">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                </div>
                                {!! Form::text('loan_date', now()->format('Y-m-d'), [
                                    'readonly' => true,
                                    'id' => 'loan_date',
                                    'class' => 'form-control fc-datepicker'.
                                        ($errors->has('loan_date') ? ' is-invalid' : '') .
                                        (!$errors->has('loan_date') && old('loan_date') ? ' is-valid' : ''),
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        {!! Form::label('first_payment_date', __('loan.first_payment_date'), ['class' => 'col-md-3 form-label required']) !!}
                        <div class="col-md-9">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                </div>
                                {!! Form::text('first_payment_date', now()->addMonth()->startOfMonth()->format('Y-m-d'), [
                                    'required' => 'required',
                                    'readonly' => true,
                                    'class' =>
                                        'form-control fc-datepicker'.
                                        ($errors->has('first_payment_date') ? ' is-invalid' : '') .
                                        (!$errors->has('first_payment_date') && old('first_payment_date') ? ' is-valid' : ''),
                                    'placeholder' => 'Input ' . __('loan.first_payment_date') . ' (YYYY-MM-DD)',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        {!! Form::label('total_loan_amount', __('loan.total_loan_amount'), ['class' => 'col-md-3 form-label required']) !!}
                        <div class="col-md-9">
                            <div class="input-group">
                            <label class="input-group-text">Rp.</label>
                            {!! Form::text('total_loan_amount', null, [
                                'id' => 'total_loan_amount',
                                'required' => 'required',
                                'inputmode'=> 'numeric',
                                'class' =>
                                    'form-control' .
                                    ($errors->has('total_loan_amount') ? ' is-invalid' : '') .
                                    (!$errors->has('total_loan_amount') && old('total_loan_amount') ? ' is-valid' : ''),
                                'placeholder' => 'Input ' . __('loan.total_loan_amount'),
                            ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        {!! Form::label('admin_fee', __('loan.admin_fee'), ['class' => 'col-md-3 form-label required']) !!}
                        <div class="col-md-2">
                            <div class="input-group">
                                <input class="form-control" type="text" id="admin_fee_percentage" min="0" max="100">
                                <label class="input-group-text">%</label>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="input-group">
                                <label class="input-group-text">Rp.</label>
                            {!! Form::text('admin_fee', null, [
                                'required' => 'required',
                                'id' => 'admin_fee',
                                'inputmode'=> 'numeric',
                                'class' =>
                                    'form-control' .
                                    ($errors->has('admin_fee') ? ' is-invalid' : '') .
                                    (!$errors->has('admin_fee') && old('admin_fee') ? ' is-valid' : ''),
                                'placeholder' => 'Input ' . __('loan.admin_fee'),
                            ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        {!! Form::label('received_amount', __('loan.received_amount'), ['class' => 'col-md-3 form-label required']) !!}
                        <div class="col-md-9">
                            <div class="input-group">
                                <label class="input-group-text">Rp.</label>
                                {!! Form::text('received_amount', null, [
                                'readonly' => true,
                                'id' => 'received_amount',
                                'required' => 'required',
                                'class' =>
                                    'form-control' .
                                    ($errors->has('received_amount') ? ' is-invalid' : '') .
                                    (!$errors->has('received_amount') && old('received_amount') ? ' is-valid' : ''),
                                'placeholder' => 'Input ' . __('loan.received_amount'),
                            ]) !!}
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        {!! Form::label('notes', __('loan.notes'), ['class' => 'col-md-3 form-label']) !!}
                        <div class="col-md-9">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="icon icon-pencil"></i>
                                </div>
                                {!! Form::textarea('notes', null, [
                                    'rows' => 4,
                                    'class' =>
                                        'form-control' .
                                        ($errors->has('notes') ? ' is-invalid' : '') .
                                        (!$errors->has('notes') && old('notes') ? ' is-valid' : ''),
                                    'placeholder' => 'Input ' . __('loan.notes'),
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    @include('admin.pages.loan_submission.loan_simulation_payment')
                </div>
                <div class="card-footer">
                    <a class="btn btn-danger" href="{{ $currentIndex }}">{{ __('general.button_cancel') }}</a>
                    <button class="btn btn-success">{{ __('general.button_save') }}</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <form target="_blank" id="formDownloadSimulasi" action="{{ route("nasabah.download-loan-simulation") }}" method="post">
        @csrf
    </form>
    @slot('script')
        @include('admin.pages.loan_submission.form-script')
        @include('admin.pages.loan_submission.loan_simulation_script')
    @endslot
    @slot('style')
        <style>
            #table-simulation th {
                font-weight: 600;
            }
        </style>
    @endslot
</x-admin-layout>
