@extends('nasabah.layout.base-nasabah')

@section('content')
    <div class="min-vh-100">
        <div class="row">
            <div class="card">
                <div class="card-title pt-5">
                    Profile
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <img src="{{ route('showimage') }}" style="height: 50px; width: 50px;">
                        </div>
                        <div class="col-9">
                            <p>{{ $employee->full_name }}</p>
                            <p>{{ $employee->nik }}</p>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-7 fw-bold">
                                {{ __('savings_employee.activity_savings_balance') }}
                            </div>
                            <div class="col-5">
                                {{ format_uang($employee->savings->activity_savings_balance) }}
                                <button data-type-balance="activity_savings_balance" data-bs-toggle="modal"
                    data-bs-target="#history-balance-modal" class="btn btn-primary btn-sm balance-card">Riwayat Saldo</button>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-7 fw-bold">
                                {{ __('savings_employee.mandatory_savings_balance') }}
                            </div>
                            <div class="col-5">
                                {{ format_uang($employee->savings->mandatory_savings_balance) }}
                                <button data-type-balance="mandatory_savings_balance" data-bs-toggle="modal"
                    data-bs-target="#history-balance-modal" class="btn btn-primary btn-sm balance-card">Riwayat Saldo</button>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-7 fw-bold">
                                {{ __('savings_employee.principal_savings_balance') }}
                            </div>
                            <div class="col-5">
                                {{ format_uang($employee->savings->principal_savings_balance) }}
                                <button data-type-balance="principal_savings_balance" data-bs-toggle="modal"
                    data-bs-target="#history-balance-modal" class="btn btn-primary btn-sm balance-card">Riwayat Saldo</button>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-7 fw-bold">
                                {{ __('savings_employee.voluntary_savings_balance') }}
                            </div>
                            <div class="col-5">
                                {{ format_uang($employee->savings->voluntary_savings_balance) }}
                                <button data-type-balance="voluntary_savings_balance" data-bs-toggle="modal"
                    data-bs-target="#history-balance-modal" class="btn btn-primary btn-sm balance-card">Riwayat Saldo</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('footer')
  @include('nasabah.layout.bottombar')
  @include('admin.pages.employee.history_balance_modal')
@endsection
@push('script')
@include('admin.pages.employee.history_balance_modal_script')
@endpush