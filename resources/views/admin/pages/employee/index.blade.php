<x-admin-layout titlePage="{{ $titlePage }}">
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-end">
                    <a href="{{ route('admin.download.export-simpanan-anggota') }}">
                        <button class="btn btn-success me-1">Download data simpanan</button>
                    </a>
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
        
        <div class="modal fade changePasswordModal" id="" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="modalPasswordLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPasswordLabel">Change Password for <span id="employeeName"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="changePasswordForm" method="POST" action="{{ route('admin.employee.change-password') }}">
                            @csrf
                            <input type="hidden" name="employee_id" id="employeeId">
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">New Password</label>
                                <input type="text" class="form-control" id="newPassword" name="new_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                <input type="text" class="form-control" id="confirmPassword" name="confirm_password" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" form="changePasswordForm" class="btn btn-primary">Change Password</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @slot('script')
        @include('admin.pages.employee.index-script-datatable')
        <script>
            $(document).ready(function () {

                // Gunakan delegated event handler pada tabel itu sendiri
                $('#datatable').on('click', '.changePassword', function() {
                    var employeeId = $(this).data('employeeid');
                    var employeeName = $(this).data('employeename');
                    $('#employeeId').val(employeeId);
                    $('#employeeName').text(employeeName);
                });
            });
        </script>
    @endslot
</x-admin-layout>
