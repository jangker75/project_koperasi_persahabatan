<x-admin-layout titlePage="{{ $titlePage }}">
    <a href="{{ $currentIndex }}" type="button" class="btn btn-danger mb-3">{{ __('general.button_cancel') }}</a>
    <div class="card">
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
                            <td>{{ $employee->gender }}</td>
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
                            <td>{{ $employee->bank }}</td>
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
                            <td>{{ __('employee.birthday') }}</td>
                            <td>{{ format_hari_tanggal($employee->birthday) }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('employee.status_employee_id') }}</td>
                            <td>{{ $employee->statusEmployee->name }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('employee.address1') }}</td>
                            <td>{{ $employee->address_1 }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('employee.address2') }}</td>
                            <td>{{ $employee->address_2 }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>