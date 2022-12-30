<x-admin-layout titlePage="{{ $titlePage }}">
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header row">
                    <div>
                        <span>Download report</span>
                    </div>
                    <div>
                        {{-- <a type="button" target="_blank" class="btn btn-primary fw-bold text-wrap" href="{{ route('admin.download.loan.report') }}">
                            <i class="fa fa-print"></i> Download Report</a> --}}
                        <button type="button" class="btn btn-primary dropdown-toggle fw-bold text-wrap" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-print me-2"></i>Download Report
                        </button>
                        <div class="dropdown-menu" style="">
                            <a class="dropdown-item" target="_blank" href="{{ route('admin.download.loan.report', ['type' => 'all']) }}">All</a>
                            <a class="dropdown-item" target="_blank" href="{{ route('admin.download.loan.report', ['type' => 'uang']) }}">Pinjaman Uang</a>
                            <a class="dropdown-item" target="_blank" href="{{ route('admin.download.loan.report', ['type' => 'barang']) }}">Pinjaman Barang</a>
                            <a class="dropdown-item" target="_blank" href="{{ route('admin.download.loan.report', ['type' => 'lainnya']) }}">Pinjaman Lainnya</a>
                        </div>
                    </div>
                    <div>
                        <span>Filter status</span>
                    </div>
                    <div class="btn-group">
                        <a type="button" data-status="All" class="btn btn-primary fw-bold text-wrap filter-btn">Semua Pinjaman</a>
                        <a type="button" data-status="Approved" class="btn btn-success text-white fw-bold text-wrap filter-btn">Pinjaman Approved</a>
                        <a type="button" data-status="Rejected" class="btn btn-warning fw-bold text-wrap filter-btn">Pinjaman Rejected</a>
                        <a type="button" data-status="Lunas" class="btn btn-success text-white fw-bold text-wrap filter-btn">Pinjaman Lunas</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap border-bottom" id="datatable">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>#</th>
                                    <th>{{ __('loan.transaction_number') }}</th>
                                    <th>{{ __('loan.loan_date') }}</th>
                                    <th>{{ __('employee.name') }}</th>
                                    <th>{{ __('loan.contract_type_id') }}</th>
                                    <th>{{ __('loan.total_loan_amount') }}</th>
                                    <th>{{ __('loan.remaining_amount') }}</th>
                                    <th>Status Approve</th>
                                    <th>Status Lunas</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @slot('script')
        @include('admin.pages.loan_list.index-script-datatable')
    @endslot
</x-admin-layout>
