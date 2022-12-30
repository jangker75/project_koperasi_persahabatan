<x-admin-layout titlePage="{{ $titlePage }}">
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header row">
                    @foreach ($totalPinjaman as $key => $item)
                        <div class="col-4">
                            <div class="card" style="background-color: rgb(214, 211, 211)">
                                <div class="row">
                                    <div class="col-4 align-items-center">
                                        <div
                                            class="card-img-absolute  circle-icon bg-success align-items-center text-center box-success-shadow bradius">
                                            <img src="{{ asset('assets/images/svgs/circle.svg') }}" alt="img" class="card-img-absolute">
                                            <i class="pe-7s-cash fs-30 text-white mt-4"></i>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body p-4">
                                            <p class="mb-2 fw-normal mt-2 fs-6">{{ $key }}</p>
                                            <p class="fw-bold fs-5 mb-0">{{ format_uang($item) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
