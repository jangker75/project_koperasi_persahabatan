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
<section class="col-12 pb-5">
    <div class="row">
        <div class="card">
            <div class="card-body ">
                <div class="row">
                    <div class="col-4">
                        <img src="{{ route('showimage', $employee->user->profile_image) }}" style="height: 80px; width: 80px;">
                    </div>
                    <div class="col-8">
                        <p class="h4 fw-bold">{{ $employee->full_name }}</p>
                        <p class="text-primary">NIK : {{ $employee->nik }}</p>
                        <a class="btn btn-primary" href="{{ route('nasabah.profile.edit', ['employee' => $employee->id]) }}">Edit profile</a>
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
                    <div class="col-12 py-4">
                      <div class="border d-flex justify-content-between align-items-center">
                        <a href="{{ route('nasabah.history-paylater') }}">Riwayat Paylater</a>
                        <i class="fa fa-angle-right    "></i>
                      </div>
                      <div class="border d-flex justify-content-between align-items-center">
                        <a href="{{ route('nasabah.history-paylater') }}">Riwayat Order</a>
                        <i class="fa fa-angle-right    "></i>
                      </div>
                      <div class="border d-flex justify-content-between align-items-center">
                        <span>Total Tagihan</span>
                        <span>{{ format_uang($totalBill) }}</span>
                      </div>
                      <div class="border d-flex justify-content-between align-items-center">
                        <span>Total Paylater</span>
                        <span>{{ format_uang($totalPaylater) }}</span>
                      </div>
                    </div>
                </div>
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
