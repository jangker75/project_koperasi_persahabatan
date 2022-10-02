<x-admin-layout titlePage="{{ $titlePage }}">
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-end">
                    <div class="dropdown me-1">
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
                    </a>
                    <a href="{{ route('admin.employee.create') }}">
                        <button class="btn btn-success me-5">Pendaftaran Anggota</button>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap border-bottom" id="datatable">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>#</th>
                                    <th>{{ __('employee.first_name') }}</th>
                                    <th>{{ __('employee.last_name') }}</th>
                                    <th>{{ __('employee.nik') }}</th>
                                    <th>{{ __('employee.nip') }}</th>
                                    <th>{{ __('employee.salary_number') }}</th>
                                    <th>{{ __('employee.position_id') }}</th>
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
        @include('admin.pages.employee.index-script-datatable')
    @endslot
</x-admin-layout>
