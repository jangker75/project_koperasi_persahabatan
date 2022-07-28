<div class="card">
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
                        <td>{{ ($loan->interest_amount_type == 'percentage') ? ($loan->interest_amount . ' %') : format_uang($loan->interest_amount) }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('loan.interest_scheme_type_id') }}</td>
                        <td>{{ $loan->interestscheme->name }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('loan.first_payment_date') }}</td>
                        <td>{{ format_tanggal( $loan->first_payment_date) }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('loan.total_pay_month') }}</td>
                        <td>{{ $loan->total_pay_month }} Bulan, Per {{ $loan->pay_per_x_month }} Bulan </td>
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
                                <th>Tanggal</th>
                                <th>Credit</th>
                                <th>Debit</th>
                                <th>Bunga</th>
                                <th>Sisa Tagihan</th>
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
                                <td>{{ format_uang($history->loan_amount_after) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>