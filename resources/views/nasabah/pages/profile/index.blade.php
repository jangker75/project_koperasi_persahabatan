@extends('nasabah.layout.base-nasabah')

@section('content')
<section class="py-4 bg-white">
    <div class="d-flex align-items-center">
        <a href="{{ route('nasabah.product.index') }}" class="btn fw-bold h5 m-0">
            <i class="fa fa-angle-left text-muted"></i>
        </a>
        <h1 class="h3 fw-bold m-0">Profile</h1>
    </div>
</section>
<section class="col-12">
    <div class="row">
        <div class="card">
            <div class="card-body ">
                <div class="row">
                    <div class="col-4">
                        <img src="{{ route('showimage') }}" style="height: 80px; width: 80px;">
                    </div>
                    <div class="col-8">
                        <p class="h4 fw-bold">{{ $employee->full_name }}</p>
                        <p class="text-primary">NIK : {{ $employee->nik }}</p>
                    </div>
                    <div class="col-12 py-4">
                        <div class="row align-items-center border">
                            <div class="col-7 fw-bold">
                                {{ __('savings_employee.activity_savings_balance') }}
                            </div>
                            <div class="col-5">
                                {{ format_uang($employee->savings->activity_savings_balance) }}
                                <button data-type-balance="activity_savings_balance" data-bs-toggle="modal"
                                    data-bs-target="#history-balance-modal"
                                    class="btn btn-primary btn-sm balance-card">Riwayat Saldo</button>
                            </div>
                        </div>
                        <div class="row align-items-center border">
                            <div class="col-7 fw-bold">
                                {{ __('savings_employee.mandatory_savings_balance') }}
                            </div>
                            <div class="col-5">
                                {{ format_uang($employee->savings->mandatory_savings_balance) }}
                                <button data-type-balance="mandatory_savings_balance" data-bs-toggle="modal"
                                    data-bs-target="#history-balance-modal"
                                    class="btn btn-primary btn-sm balance-card">Riwayat Saldo</button>
                            </div>
                        </div>
                        <div class="row align-items-center border">
                            <div class="col-7 fw-bold">
                                {{ __('savings_employee.principal_savings_balance') }}
                            </div>
                            <div class="col-5">
                                {{ format_uang($employee->savings->principal_savings_balance) }}
                                <button data-type-balance="principal_savings_balance" data-bs-toggle="modal"
                                    data-bs-target="#history-balance-modal"
                                    class="btn btn-primary btn-sm balance-card">Riwayat Saldo</button>
                            </div>
                        </div>
                        <div class="row align-items-center border">
                            <div class="col-7 fw-bold">
                                {{ __('savings_employee.voluntary_savings_balance') }}
                            </div>
                            <div class="col-5">
                                {{ format_uang($employee->savings->voluntary_savings_balance) }}
                                <button data-type-balance="voluntary_savings_balance" data-bs-toggle="modal"
                                    data-bs-target="#history-balance-modal"
                                    class="btn btn-primary btn-sm balance-card">Riwayat Saldo</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="col-12">
    <div class="row border">
        <div class="col-12">
            <div class="card">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="{{ route('nasabah.history-paylater') }}">Riwayat Paylater</a></li>
                    <li class="list-group-item">A second item</li>
                    <li class="list-group-item">A third item</li>
                </ul>
            </div>
        </div>
    </div>
</section>

@endsection

@section('footer')
@include('nasabah.layout.bottombar')
@include('admin.pages.employee.history_balance_modal')
@endsection
@push('script')
@include('admin.pages.employee.history_balance_modal_script')
@endpush
