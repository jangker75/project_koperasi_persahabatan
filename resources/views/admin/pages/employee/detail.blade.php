<x-admin-layout>
    <a href="{{ $currentIndex }}" type="button" class="btn btn-danger mb-3">{{ __('general.button_cancel') }}</a>
    <div class="row">
        <div class="col-md-6 col-lg-3">
            <x-employee.employee-balance-card-component :text="__('savings_employee.principal_savings_balance')" :value="$employee->savings->principal_savings_balance"
                type_balance="principal_savings_balance" />
        </div>
        <div class="col-md-6 col-lg-3">
            <x-employee.employee-balance-card-component :text="__('savings_employee.mandatory_savings_balance')" :value="$employee->savings->mandatory_savings_balance"
                type_balance="mandatory_savings_balance" />
        </div>
        <div class="col-md-6 col-lg-3">
            <x-employee.employee-balance-card-component :text="__('savings_employee.activity_savings_balance')" :value="$employee->savings->activity_savings_balance"
                type_balance="activity_savings_balance" />
        </div>
        <div class="col-md-6 col-lg-3">
            <x-employee.employee-balance-card-component :text="__('savings_employee.voluntary_savings_balance')" :value="$employee->savings->voluntary_savings_balance"
                type_balance="voluntary_savings_balance" />
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4>Riwayat Pinjaman</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <td class="fw-bold">{{ __('loan.transaction_number') }}</td>
                            <td class="fw-bold">{{ __('loan.total_loan_amount') }}</td>
                            <td class="fw-bold">{{ __('loan.remaining_amount') }}</td>
                            <td class="fw-bold">{{ __('loan.status') }}</td>
                            <td class="fw-bold">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($employee->loan->count() > 0)
                            @foreach ($employee->loan as $loan)
                                <tr>
                                    <td>{{ $loan->transaction_number }}</td>
                                    <td>{{ format_uang($loan->total_loan_amount) }}</td>
                                    <td>{{ format_uang($loan->remaining_amount) }}</td>
                                    <td>
                                        @php
                                            $class = $loan->approvalstatus->name == 'Waiting' ? 'bg-warning' : ($loan->approvalstatus->name == 'Approved' ? 'bg-success' : 'bg-danger');
                                        @endphp
                                        <span
                                            class="badge {{ $class }} rounded-pill text-white fw-bold p-2 px-3">{{ $loan->approvalstatus->name }}</span>
                                    </td>
                                    <td>
                                        {{-- <button data-bs-toggle="modal" data-loan-id="{{ $loan->id }}"
                                            data-loan-number="{{ $loan->transaction_number }}"
                                        data-bs-target="#modalHistoryLoan" class="btn btn-primary btn-sm loan-history-modal">Lihat Detail</button> --}}
                                        <button data-bs-toggle="modal"
                                            value="{{ route('admin.loan-list.show', [$loan->id]) }}"
                                            data-loan-number="{{ $loan->transaction_number }}"
                                            data-bs-target="#modalHistoryLoan"
                                            class="btn btn-primary btn-sm loan-history-modal">Lihat Detail</button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center fw-bold" colspan="4">No data</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4>Informasi Nasabah</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>{{ __('employee.first_name') }}</td>
                            <td>{{ $employee->first_name }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('employee.last_name') }}</td>
                            <td>{{ $employee->last_name }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('employee.nik') }}</td>
                            <td>{{ $employee->nik }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('employee.nip') }}</td>
                            <td>{{ $employee->nip }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('employee.gender') }}</td>
                            <td>{{ \App\Enums\ConstantEnum::GENDER[$employee->gender] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('employee.position_id') }}</td>
                            <td>{{ $employee->position->name }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('employee.department_id') }}</td>
                            <td>{{ $employee->department->name }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('employee.phone') }}</td>
                            <td>{{ $employee->phone }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('employee.bank') }}</td>
                            <td>{{ \App\Enums\ConstantEnum::BANK[$employee->bank] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('employee.rekening') }}</td>
                            <td>{{ $employee->rekening }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('employee.salary') }}</td>
                            <td>{{ format_uang($employee->salary) }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('employee.status_employee_id') }}</td>
                            <td>{{ $employee->statusEmployee->name }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('employee.birthplace') }}</td>
                            <td>{{ $employee->birthplace }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('employee.birthday') }}</td>
                            <td>{{ format_hari_tanggal($employee->birthday) }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('employee.age') }}</td>
                            <td>{{ $employee->age }} Tahun</td>
                        </tr>
                        <tr>
                            <td>{{ __('employee.profile_image') }}</td>
                            <td>
                                <a data-lightbox='roadtrip' href='{{ route('showimage', [$employee->user->profile_image]) }}'>
                                    <img style='max-width:160px' title="Image For Foto"
                                        src='{{ route('showimage', [$employee->user->profile_image]) }}' />
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>{{ __('employee.status_employee_id') }}</td>
                            <td>{{ $employee->statusEmployee->name }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('employee.registered_date') }}</td>
                            <td>{{ format_hari_tanggal($employee->registered_date) }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('employee.address_1') }}</td>
                            <td>{{ $employee->address_1 }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('employee.address_2') }}</td>
                            <td>{{ $employee->address_2 }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <a href="{{ $currentIndex }}" type="button" class="btn btn-danger mb-3">{{ __('general.button_cancel') }}</a>
    @include('admin.pages.employee.history_balance_modal')
    @include('admin.pages.employee.history_loan_modal')
    @slot('script')
        <script>
            $(document).ready(function() {
                //Show modal balance history
                $('.balance-card').on('click', function(e) {
                    let type = $(this).data('type-balance')
                    $('#table-history-balance-modal tbody tr').remove()
                    let tRow = ''
                    $.ajax({
                        type: "get",
                        url: "{{ url('admin/employee-savings-history') . '/' . "$employee->id" . '/' }}" +
                            type,
                        dataType: "json",
                        success: function(response) {
                            $('#history-modal-title').text(response.type)
                            response.data.forEach(item => {
                                tRow += "<tr><td>" +
                                    item.transaction_date + "</td><td>" +
                                    (item.transaction_type == 'credit' ? item.amount : "") +
                                    "</td><td>" +
                                    (item.transaction_type == 'debit' ? item.amount : "") +
                                    "</td><td>" +
                                    item.balance_after + "</td></tr>"
                            })
                        }
                    }).then(() => {
                        $('#table-history-balance-modal tbody').append(tRow)
                    });
                })

                //Show modal loan history
                $('.loan-history-modal').click(function() {
                    $('#loanmodalcontent').load($(this).attr('value'))
                    $('#modalTitle').text($(this).data('loan-number'))
                })

            })
        </script>
    @endslot
</x-admin-layout>
