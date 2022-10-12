<x-admin-layout titlePage="{{ $titlePage }}">
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
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
        @include('admin.pages.ex_employee.index-script-datatable')
    @endslot
</x-admin-layout>
