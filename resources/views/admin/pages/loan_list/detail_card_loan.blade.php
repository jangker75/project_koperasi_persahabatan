<div class="card">
    <div class="card-header">
        <div class="row d-flex">
            @php
                $class = $loan->is_lunas ? 'bg-success' : 'bg-warning';
                $text = $loan->is_lunas ? 'Lunas' : 'Belum Lunas';
            @endphp
            <span class="badge {{ $class }} text-white fw-bold p-2 px-3 fs-24">{{ $text }}</span>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td class="fw-bold fs-5" colspan="2">Informasi Karyawan</td>
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
                        <td>{{ __('employee.phone') }}</td>
                        <td>{{ __($loan->employee->phone) }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold fs-5" colspan="2">Informasi Pinjaman</td>
                    </tr>
                    <tr>
                        <td>{{ __('loan.response_user') }}</td>
                        <td>{{ $loan->response_user }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('loan.response_date') }}</td>
                        <td>{{ format_hari_tanggal_jam($loan->response_date) }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('loan.transaction_number') }}</td>
                        <td>{{ $loan->transaction_number }}</td>
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
                        <td>{{ __('loan.admin_fee') }}</td>
                        <td>{{ format_uang($loan->admin_fee) }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('loan.received_amount') }}</td>
                        <td>{{ format_uang($loan->received_amount) }}</td>
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
                        <td>{{ __('loan.first_payment_date') }}</td>
                        <td>{{ format_tanggal($loan->first_payment_date) }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('loan.total_pay_month') }}</td>
                        <td>{{ $loan->total_pay_month }} Bulan, Per {{ $loan->pay_per_x_month }} Bulan </td>
                    </tr>
                    <tr>
                        <td>Pembayaran pokok</td>
                        <td>{{ format_uang($loan->payment_tenor) }}/Bulan</td>
                    </tr>
                    @if (!$loan->is_lunas)
                        <tr>
                            <td>Bunga bulan ini</td>
                            <td>{{ format_uang($loan->actual_interest_amount) }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td>{{ __('loan.notes') }}</td>
                        <td>{{ $loan->notes }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('loan.attachment') }}</td>
                        <td>
                            @if (isset($loan->attachment) || $loan->attachment != null)
                                {!! Form::open(['route' => 'admin.loan.destroy.attachment', 'class' => 'form-control']) !!}
                                @csrf
                                {!! Form::hidden('id', $loan->id) !!}
                                <a target="_blank" href="{{ route('showimage', $loan->attachment) }}"
                                    class="btn btn-primary d-inline-block">Download/View</a>
                                <button type="submit" class="btn btn-warning">Delete</button>
                                {!! Form::close() !!}
                            @else
                                {!! Form::open(['route' => 'admin.loan.upload.attachment', 'files' => true, 'class' => 'form-control']) !!}
                                @csrf
                                {!! Form::hidden('id', $loan->id) !!}
                                <input required type="file" name="attachment" class="form-control">
                                <button type="submit" class="btn btn-primary">Save</button>
                                {!! Form::close() !!}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
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
    </div>
</div>
