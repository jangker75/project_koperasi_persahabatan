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
