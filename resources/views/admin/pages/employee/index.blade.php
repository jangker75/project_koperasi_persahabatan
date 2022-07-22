<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-end">
                    <a href="{{ route('admin.employee.create') }}">
                        <button class="btn btn-success me-5">{{ __('general.button_add_new_data') }}</button></a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap border-bottom" id="datatable">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>#</th>
                                    <th>First name</th>
                                    <th>Last name</th>
                                    <th>NIK</th>
                                    <th>NIP</th>
                                    <th>Salary</th>
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
