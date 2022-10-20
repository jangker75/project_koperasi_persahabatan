<x-admin-layout>
    <a href="{{ $currentIndex }}" type="button" class="btn btn-danger mb-3">{{ __('general.button_cancel') }}</a>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <span class="fw-bold fs-5">Informasi Pinjaman</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td>{{ __('loan.transaction_number') }}</td>
                                <td>{{ $loan->transaction_number }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('employee.name') }}</td>
                                <td>{{ __($loan->employee->full_name) }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('employee.nik') }}</td>
                                <td>{{ __($loan->employee->nik) }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('loan.loan_date') }}</td>
                                <td>{{ format_hari_tanggal($loan->loan_date) }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('loan.total_loan_amount') }}</td>
                                <td>{{ format_uang($loan->total_loan_amount) }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('loan.interest_amount') }}</td>
                                <td>{{ $loan->interest_amount_type == 'percentage' ? $loan->interest_amount . ' %' : format_uang($loan->interest_amount) }}
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('loan.interest_scheme_type_id') }}</td>
                                <td>{{ $loan->interestscheme->name }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('loan.total_pay_month') }}</td>
                                <td>{{ $loan->total_pay_month }} Bulan, Per {{ $loan->pay_per_x_month }} Bulan</td>
                            </tr>
                            <tr>
                                <td>Pembayaran pokok</td>
                                <td>{{ format_uang($loan->payment_tenor) }}/Bulan</td>
                            </tr>
                            <tr>
                                <td>Bunga bulan ini</td>
                                <td>{{ format_uang($loan->actual_interest_amount) }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('loan.notes') }}</td>
                                <td>{{ $loan->notes }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                {{-- History Loan --}}
                <div class="card">
                    <div class="card-header">
                        Riwayat
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="fw-bold">Tanggal</th>
                                        <th class="fw-bold">Credit</th>
                                        <th class="fw-bold">Debit</th>
                                        <th class="fw-bold">Bunga</th>
                                        <th class="fw-bold">Total</th>
                                        <th class="fw-bold">Sisa Tagihan</th>
                                        <th class="fw-bold">Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($loan->loanhistory as $history)
                                    <tr>
                                        <td>{{ format_hari_tanggal($history->transaction_date) }}</td>
                                        @if ($history->transaction_type == 'credit')
                                            <td>{{ format_uang($history->total_payment) }}</td>
                                            <td></td>
                                        @else
                                            <td></td>
                                            <td>{{ format_uang($history->total_payment) }}</td>
                                        @endif
                                        <td>{{ format_uang($history->interest_amount) }}</td>
                                        <td>{{ format_uang($history->interest_amount + $history->total_payment) }}</td>
                                        <td>{{ format_uang($history->loan_amount_after) }}</td>
                                        <td>{{ $history->description }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>  
                {{-- End History Loan --}}
            </div>
        </div>
        <div class="row">
            {{-- Form Full Payment --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <span class="fw-bold fs-5">Pelunasan</span>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="input-group">
                                    {!! Form::label('remaining_amount', 'Sisa Pinjaman', ['class' => 'col-md-5 form-label']) !!}
                                    {!! Form::text('remaining_amount', format_uang($loan->remaining_amount), [
                                        'class' => 'form-control',
                                        'readonly' => true,
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="input-group">
                                    {!! Form::label('must_pay', 'Jumlah yang harus dibayar', ['class' => 'col-md-5 form-label']) !!}
                                    {!! Form::text('must_pay', format_uang($loan->remaining_amount), [
                                        'class' => 'form-control',
                                        'readonly' => true,
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        {{-- Open form fullpayment --}}
                        {!! Form::open(['route' => 'admin.loan.fullpayment.store', 'files' => true, 'class' => 'form-horizontal']) !!}
                        {!! Form::hidden('loan_id', $loan->id) !!}
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="input-group">
                                    {!! Form::label('description', 'Catatan Lunas', ['class' => 'col-md-5 form-label required']) !!}
                                    {!! Form::textarea('description', null, ['class' => 'form-control', 'required' => 'required', 'rowspan' => 3]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <button class="btn btn-primary w-25" name="form-pelunasan" type="submit">Lunasi</button>
                        </div>
                        {!! Form::close() !!}
                        {{-- Close Form fullpayment --}}
                    </div>
                </div>
            </div>
            {{-- End Form Full Payment --}}

            {{-- Form Some Payment --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <span class="fw-bold fs-5">Revisi</span>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="input-group">
                                    {!! Form::label('remaining_amount', 'Sisa Pinjaman', ['class' => 'col-md-5 form-label']) !!}
                                    {!! Form::text('remaining_amount', format_uang($loan->remaining_amount), [
                                        'class' => 'form-control',
                                        'readonly' => true,
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        {{-- Open form somepayment --}}
                        {!! Form::open(['route' => 'admin.loan.somepayment.store', 'files' => true, 'class' => 'form-horizontal']) !!}
                        {!! Form::hidden('loan_id', $loan->id) !!}
                        {!! Form::hidden('payment_type', 'credit') !!}
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="input-group">
                                    {!! Form::label('payment_type', 'Credit', ['class' => 'col-md-5 form-label']) !!}
                                    {!! Form::select('payment_type', \App\Enums\ConstantEnum::TRANSACTION_TYPE, 'credit', ['class' => 'form-select', 'disabled' => true]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="input-group">
                                    {!! Form::label('amount', 'Nominal', ['class' => 'col-md-5 form-label required']) !!}
                                    {!! Form::number('amount', null, ['class' => 'form-control required']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="input-group">
                                    {!! Form::label('description', 'Catatan', ['class' => 'col-md-5 form-label required']) !!}
                                    {!! Form::textarea('description', null, ['class' => 'form-control', 'required' => 'required', 'rowspan' => 3]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <button class="btn btn-primary w-25" name="form-cicilan" type="submit">Submit</button>
                        </div>
                        {!! Form::close() !!}
                        {{-- Close Form somepayment --}}
                    </div>
                </div>
            </div>
            {{-- End Form Some Payment --}}
        </div>
    </div>
    <a href="{{ $currentIndex }}" type="button" class="btn btn-danger mb-3">{{ __('general.button_cancel') }}</a>
</x-admin-layout>
