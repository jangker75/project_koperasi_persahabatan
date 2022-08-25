@extends('nasabah.layout.base-nasabah')
@section('content')
<div class="min-vh-100 pb-8">

        <a href="{{ route('nasabah.home') }}" type="button" class="btn btn-warning my-2">{{ __('general.button_cancel') }}</a>
        @if ($isAnyLoan)
        <div class="expanel expanel-danger">
            <div class="expanel-heading">
                Notification
            </div>
            <div class="expanel-body">
                Anda mempunyai pinjaman yang sedang berjalan, tidak bisa mengajukan pinjaman lain
            </div>
        </div>
        @else
        {!! Form::open(['route' => 'nasabah.loan-submission.store', 'files' => true, 'class' => 'form-horizontal']) !!}
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    {!! Form::label('employee_name', __('employee.name'), ['class' => 'form-label required']) !!}
                    {!! Form::text('employee_name', auth()->user()->employee->full_name, [
                        'readonly' => true,
                        'class' => 'form-control'
                    ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('contract_type_id', __('loan.contract_type_id'), ['class' => 'form-label required']) !!}
                    {!! Form::select('contract_type_id', $contractTypeList, null, [
                        'required' => 'required',
                        'class' =>
                            'form-control form-select select2' .
                            ($errors->has('contract_type_id') ? ' is-invalid' : '') .
                            (!$errors->has('contract_type_id') && old('contract_type_id') ? ' is-valid' : ''),
                        'placeholder' => 'Input ' . __('loan.contract_type_id'),
                    ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('loan_date', __('loan.loan_date'), ['class' => 'form-label required']) !!}
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
                <div class="form-group">
                    {!! Form::label('first_payment_date', __('loan.first_payment_date'), ['class' => 'form-label required']) !!}
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
                <div class="form-group">
                    {!! Form::label('total_loan_amount', __('loan.total_loan_amount'), ['class' => 'form-label required']) !!}
                        <div class="input-group">
                        <label class="input-group-text">Rp.</label>
                        {!! Form::text('total_loan_amount', null, [
                            'id' => 'total_loan_amount',
                            'required' => 'required',
                            'placeholder' => 'Jumlah pinjaman',
                            'inputmode'=> 'numeric',
                            'class' =>
                                'form-control' .
                                ($errors->has('total_loan_amount') ? ' is-invalid' : '') .
                                (!$errors->has('total_loan_amount') && old('total_loan_amount') ? ' is-valid' : ''),
                            'placeholder' => 'Input ' . __('loan.total_loan_amount'),
                        ]) !!}
                        </div>
                </div>
                <div class="form-group">
                    {!! Form::label('admin_fee', __('loan.admin_fee'), ['class' => 'form-label required']) !!}
                    <div class="row">
                        <div class="col-4">
                            <div class="input-group">
                                <input readonly class="form-control" type="text" id="admin_fee_percentage" min="0" max="100">
                                <label class="input-group-text">%</label>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="input-group">
                                <label class="input-group-text">Rp.</label>
                            {!! Form::text('admin_fee', null, [
                                'readonly' => true,
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
                </div>
                <div class="form-group">
                    {!! Form::label('received_amount', __('loan.received_amount'), ['class' => 'form-label required']) !!}
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
                <div class="form-group">
                    {!! Form::label('total_pay_month', __('loan.total_pay_month'), ['class' => 'form-label required']) !!}
                    {!! Form::number('total_pay_month', 12, [
                        'required' => 'required',
                        'id' => 'total_pay_month',
                        'class' =>
                            'form-control' .
                            ($errors->has('total_pay_month') ? ' is-invalid' : '') .
                            (!$errors->has('total_pay_month') && old('total_pay_month') ? ' is-valid' : ''),
                    ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('pay_per_x_month', __('loan.pay_per_x_month'), ['class' => 'form-label required']) !!}
                    <div class="input-group">
                        {!! Form::number('pay_per_x_month', 1, [
                            'required' => 'required',
                            'id' => 'pay_per_x_month',
                            'class' =>
                                'form-control' .
                                ($errors->has('pay_per_x_month') ? ' is-invalid' : '') .
                                (!$errors->has('pay_per_x_month') && old('pay_per_x_month') ? ' is-valid' : ''),
                            'placeholder' => 'Input ' . __('loan.pay_per_x_month'),
                        ]) !!}
                        <label class="input-group-text">bulan</label>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('notes', __('loan.notes'), ['class' => 'form-label']) !!}
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
            <div class="card-footer">
                <button class="btn btn-success">{{ __('general.button_save') }}</button>
            </div>
        </div>
        {!! Form::close() !!}
        @endif
        
    </div>
@endsection
@push('script')
    @include('nasabah.pages.loan.form_script')
@endpush
@section('footer')
    @include('nasabah.layout.bottombar')
@endsection
