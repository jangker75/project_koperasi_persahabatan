<x-admin-layout titlePage="{{ $titlePage }}">
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-end">
                    <a href="{{ route('admin.loan-submission.create') }}">
                        <button class="btn btn-success me-5">Pengajuan Pinjaman Baru</button>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap border-bottom" id="datatable">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>#</th>
                                    <th>{{ __('loan.transaction_number') }}</th>
                                    <th>{{ __('employee.name') }}</th>
                                    <th>{{ __('loan.total_loan_amount') }}</th>
                                    <th>{{ __('loan.loan_approval_status_id') }}</th>
                                    <th>{{ __('loan.created_by') }}</th>
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
        @include('admin.pages.loan_submission.index-script-datatable')
    @endslot
</x-admin-layout>
