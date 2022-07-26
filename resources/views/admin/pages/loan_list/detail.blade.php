<x-admin-layout>
    <a href="{{ $currentIndex }}" type="button" class="btn btn-danger mb-3">{{ __('general.button_cancel') }}</a>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>{{ __('loan.transaction_number') }}</td>
                            <td>{{ $loan->transaction_number }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('loan.total_loan_amount') }}</td>
                            <td>{{ format_uang($loan->total_loan_amount) }}</td>
                        </tr>
                        
                        <tr>
                            <td>{{ __('loan.first_payment_date') }}</td>
                            <td>{{ format_tanggal( $loan->first_payment_date) }}</td>
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
                                    <td>{{ $history->transaction_date }}</td>
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
</x-admin-layout>