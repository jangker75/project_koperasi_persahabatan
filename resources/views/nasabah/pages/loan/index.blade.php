@extends('nasabah.layout.base-nasabah')
@section('content')
<section class="py-4 bg-white">
    <div class="d-flex align-items-center">
        <a href="{{ route('nasabah.home') }}" class="btn fw-bold h5 m-0">
            <i class="fa fa-angle-left text-muted"></i>
        </a>
        <h1 class="h3 fw-bold m-0">Pinjaman Anda</h1>
    </div>
</section>
    <div class="min-vh-100 pb-6">
        {{-- <a href="{{ route('nasabah.home') }}" type="button" class="btn btn-warning my-2">{{ __('general.button_cancel') }}</a> --}}
        <div class="card">
            <div class="card-header bg-azure fs-6">
                Status Pengajuan Pinjaman
            </div>
            <div class="card-body">
                @if ($waitingLoans->count() == 0 || $waitingLoans == null)
                <p>Tidak ada pengajuan pinjaman</p>                    
                @else
                @foreach ($waitingLoans as $loan)
                <div class="expanel expanel-primary">
                    <div class="expanel-heading">
                        {{ $loan->transaction_number }} (Waiting Approval)
                    </div>
                    <div class="expanel-body">
                        <table class="table table-bordered table-responsive">
                            <tbody>
                                <tr>
                                    <td>{{ __('loan.loan_date') }}</td>
                                    <td>{{ format_tanggal($loan->loan_date) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('loan.contract_type_id') }}</td>
                                    <td>{{ $loan->contracttype->name }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('loan.total_pay_month') }}</td>
                                    <td>{{ $loan->total_pay_month }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('loan.total_loan_amount') }}</td>
                                    <td>{{ format_uang($loan->total_loan_amount) }}</td>
                                </tr>
                                <tr>
                                    <td>Pembayaran Pokok</td>
                                    <td>{{ format_uang($loan->payment_tenor) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
        <div class="card">
            <div class="card-header fs-6">
                <p>Pinjaman Berjalan</p>
            </div>
            <div class="card-body">
                <div class="expanel expanel-primary">
                    <div class="expanel-heading">
                        {{ $ongoingLoan == null ? '' : $ongoingLoan->transaction_number }}
                    </div>
                    @if ($ongoingLoan == null)
                    <div class="expanel-body">
                      <span>Tidak Ada Data</span>
                    </div>
                    @else
                    <div class="expanel-body">
                        <button data-bs-toggle="modal" value="{{ route('nasabah.loan.show', [$ongoingLoan->id]) }}"
                            data-loan-number="{{ $ongoingLoan->transaction_number }}" data-bs-target="#modalHistoryLoan"
                            class="btn btn-primary btn-sm loan-history-modal">Lihat Detail</button>
                        <table class="table table-bordered table-responsive ongoingloan-table">
                            <tbody>
                                @if ($ongoingLoan == null)
                                    <tr>
                                        <td>Tidak Ada pinjaman berjalan</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>{{ __('loan.loan_date') }}</td>
                                        <td>{{ format_tanggal($ongoingLoan->loan_date) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('loan.total_pay_month') }}</td>
                                        <td>{{ $ongoingLoan->total_pay_month }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('loan.total_loan_amount') }}</td>
                                        <td>{{ format_uang($ongoingLoan->total_loan_amount) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Pembayaran Pokok</td>
                                        <td>{{ format_uang($ongoingLoan->payment_tenor) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('loan.remaining_amount') }}</td>
                                        <td>{{ format_uang($ongoingLoan->remaining_amount) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('loan.interest_amount') }}</td>
                                        <td>{{ format_uang($ongoingLoan->actual_interest_amount) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kontrak</td>
                                        <td>
                                            @if (isset($ongoingLoan->attachment) || $ongoingLoan->attachment != null)
                                            <a target="_blank" href="{{ route('showimage', $ongoingLoan->attachment) }}"
                                                class="btn btn-primary d-inline-block">Download/View</a>
                                            @else
                                            Silahkan datang ke koperasi<br> untuk tanda tangan kontrak
                                            @endif
                                        </td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header fs-6">
                Riwayat Pinjaman
            </div>
            <div class="card-body">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    @foreach ($loansHistory as $loan)
                        <div class="panel panel-default active">
                            <div class="panel-heading " role="tab" id="headingOne1">
                                <h4 class="panel-title">
                                    <a role="button" data-bs-toggle="collapse" data-bs-parent="#accordion"
                                        href="#collapse{{ $loan->id }}" aria-expanded="true" aria-controls="collapse{{ $loan->id }}" class="active">
                                        {{ $loan->transaction_number }}
                                        <br>{{ format_uang($loan->total_loan_amount) }}
                                    </a>
                                    
                                </h4>
                            </div>
                            <div id="collapse{{ $loan->id }}" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="headingOne1" style="">
                                <div class="panel-body">
                                    <button data-bs-toggle="modal" value="{{ route('nasabah.loan.show', [$loan->id]) }}"
                                        data-loan-number="{{ $loan->transaction_number }}" data-bs-target="#modalHistoryLoan"
                                        class="btn btn-primary btn-sm loan-history-modal">Lihat Detail</button>
                                    <table class="table table-bordered table-responsive ongoingloan-table">
                                        <tbody>
                                            <tr>
                                                <td>{{ __('loan.loan_date') }}</td>
                                                <td>{{ format_hari_tanggal($loan->loan_date) }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('loan.status') }}</td>
                                                <td>
                                                    @php
                                                        $bg = [
                                                            'Approved' => 'bg-success',
                                                            'Waiting' => 'bg-warning',
                                                            'Rejected' => 'bg-danger',
                                                        ];
                                                    @endphp 
                                                    <span class="badge rounded-pill {{ $bg[$loan->approvalstatus->name] }}">{{ $loan->approvalstatus->name }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Status Lunas</td>
                                                <td>{{ $loan->is_lunas ? 'Lunas' : "Belum Lunas" }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('loan.total_pay_month') }}</td>
                                                <td>{{ $loan->total_pay_month }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('loan.total_loan_amount') }}</td>
                                                <td>{{ format_uang($loan->total_loan_amount) }}</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('nasabah.layout.bottombar')
    @include('nasabah.pages.loan.history_loan_modal')
@endsection
@push('script')
    <script>
        //Show modal loan history
        $('.loan-history-modal').click(function() {
            $('#loanmodalcontent').load($(this).attr('value'))
            $('#modalTitle').text($(this).data('loan-number'))
        })
    </script>
@endpush
@push('style')
    <style>
        table tr td {
            white-space: nowrap;
        }
    </style>
@endpush
