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
        <div class="col-12 py-2">
            <div class="row">
                <div class="col-4 d-flex justify-content-center align-items-center">
                    {{-- <img src="{{ route('showimage', $employee->user->profile_image) }}" style="height: 80px; width:
                    80px;">
                    --}}
                    <img src="http://127.0.0.1:8000/storage/default-image.jpg" class="rounded border border-primary p-0"
                        style="height: 80px; width: 80px;">
                </div>
                <div class="col-8">
                    <p class="h3 fw-bold">{{ $employee->full_name }}</p>
                    {{-- <p class="text-dark">NIK : {{ $employee->nik }}</p> --}}
                    <a class="btn btn-primary btn-sm"
                        href="{{ route('nasabah.profile.edit', ['employee' => $employee->id]) }}">Edit profile</a>
                    {!! Form::open(['route' => 'admin.logout', 'method' => 'POST']) !!}
                    <button type="submit" class="btn btn-warning">
                        <i class="dropdown-icon fe fe-alert-circle"></i> Sign out
                    </button>
                    {!! Form::close() !!}
                </div>
                <div class="col-12 pt-4">
                    <div class="card border m-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">NIK (Nomor Induk Koperasi) : {{ $employee->nik }}</li>
                            <li class="list-group-item">NIP (Nomor Induk Pegawai) : {{ $employee->nip }}</li>
                            <li class="list-group-item">Pangkat/Golongan : {{ $employee->department->name }}</li>
                            <li class="list-group-item">Status Karyawan : {{ $employee->statusEmployee->name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 py-2">
            <div class="card bg-primary-gradient text-white m-0">
                <div class="card-body">
                    <div class="h4 fw-bold">Detail Saldo {{ $employee->full_name }}</div>
                    <div class="row row-sm">
                        <div class="col-6 p-0">
                            <div class="p-2" style="border-radius:4px;">
                                <div class="fw-bold h5 m-0">
                                    {{ format_uang($employee->savings->activity_savings_balance) }}
                                </div>
                                <span class="text-small">
                                    {{ __('savings_employee.activity_savings_balance') }}
                                </span>
                            </div>
                        </div>
                        <div class="col-6 p-0">
                            <div class="p-2" style="border-radius:4px;">
                                <div class="fw-bold h5 m-0">
                                    {{ format_uang($employee->savings->mandatory_savings_balance) }}
                                </div>
                                <span class="text-small">
                                    {{ __('savings_employee.mandatory_savings_balance') }}
                                </span>
                            </div>
                        </div>
                        <div class="col-6 p-0">
                            <div class="p-2" style="border-radius:4px;">
                                <div class="fw-bold h5 m-0">
                                    {{ format_uang($employee->savings->principal_savings_balance) }}
                                </div>
                                <span class="text-small">
                                    {{ __('savings_employee.principal_savings_balance') }}
                                </span>
                            </div>
                        </div>
                        <div class="col-6 p-0">
                            <div class="p-2" style="border-radius:4px;">
                                <div class="fw-bold h5 m-0">
                                    {{ format_uang($employee->savings->voluntary_savings_balance) }}
                                </div>
                                <span class="text-small">
                                    {{ __('savings_employee.voluntary_savings_balance') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="border bg-danger-transparent p-3 mb-2" style="border-radius: 8px;">
                <span class="h5 text-danger m-0">Total Tagihan Paylater : {{ format_uang($totalPaylater) }}</span>
            </div>
            <div class="border bg-danger-transparent p-3 mb-2" style="border-radius: 8px;">
                <span class="h5 text-danger m-0">Total Tagihan Pinjaman : Rp 0</span>
            </div>
            <a href="{{ route('nasabah.history-paylater') }}" class="border d-flex justify-content-between align-items-center my-3 shadow" style="border-radius: 8px;">
                <span>Riwayat Order</span>
                <i class="fa fa-angle-right"></i>
            </a>
            <div class="border d-flex justify-content-between align-items-center my-3 shadow" style="border-radius: 8px;">
                <a href="#">Riwayat Pinjaman</a>
                <i class="fa fa-angle-right"></i>
            </div>
        </div>
    </div>
    <div class="py-4 my-4"></div>
</section>


@endsection

@section('footer')
@include('nasabah.layout.bottombar')
@include('admin.pages.employee.history_balance_modal')
@endsection
@push('script')
@include('admin.pages.employee.history_balance_modal_script')
@endpush
