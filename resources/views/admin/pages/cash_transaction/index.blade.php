<x-admin-layout titlePage="{{ $titlePage }}">
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-end">
                    {{-- <div class="dropdown me-1">
                        <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-print me-2"></i>Download Data Nasabah
                            </button>
                        <div class="dropdown-menu" style="">
                            <a class="dropdown-item" target="_blank" href="{{ route('admin.download.data-nasabah', ['type' => 'pdf']) }}">Export PDF</a>
                            <a class="dropdown-item" target="_blank" href="{{ route('admin.download.data-nasabah', ['type' => 'xls']) }}">Export Excel</a>
                        </div>
                    </div>
                    <a href="{{ route('admin.employee.out') }}">
                        <button class="btn btn-warning me-1">Anggota Keluar</button>
                    </a> --}}
                    <a href="{{ route('admin.cash-in-out.create') }}">
                        <button class="btn btn-success me-5">Tambah Data</button>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap border-bottom" id="datatable">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>#</th>
                                    <th>{{ __('cash_transaction.user_id') }}</th>
                                    <th>{{ __('cash_transaction.amount') }}</th>
                                    <th>{{ __('cash_transaction.transaction_date') }}</th>
                                    <th>{{ __('cash_transaction.transaction_type') }}</th>
                                    <th>{{ __('cash_transaction.description') }}</th>
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
        @include('admin.pages.cash_transaction.index-script-datatable')
    @endslot
</x-admin-layout>
