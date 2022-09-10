@extends('nasabah.layout.base-nasabah')

@section('content')
<section class="py-4 bg-white">
    <div class="d-flex align-items-center">
        <a href="{{ route('nasabah.profile') }}" class="btn fw-bold h5 m-0">
            <i class="fa fa-angle-left text-muted"></i>
        </a>
        <h1 class="h3 fw-bold m-0">Riwayat Paylater</h1>
    </div>
</section>
<section class="col-12 py-4" style="min-height: 90vh;">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Riwayat Paylater <strong class="fw-bold">{{ $employee->full_name }}</strong></div>
        </div>
        <div class="card-body p-2">
            @if ($paylater == null)
              <div class="w-100 border text-center h4" style="background-color: #dbdbdb;">Belum ada riwayat paylater</div>
            @else
              @foreach ($paylater as $paylate)
            <div class="w-100 border-top border-bottom p-2">
                <div class="text-info text-small">Kode order : {{ $paylate->order_code }}</div>
                <div class="w-100 d-flex py-2 align-items-center justify-content-between">
                    <div class="text-field">
                        <div class="h4 fw-bold m-0 pb-2">{{ format_uang($paylate->amount) }}</div>
                        <div class="d-flex">
                            <div>{{ $paylate->requestDate }}</div>
                            <div class="ms-4 btn btn-sm {{ $paylate->statusColor }} text-white fw-bold">{{ $paylate->status }}</div>
                        </div>
                    </div>
                    <div class="button-field">
                      <a href="{{ route('nasabah.detail-order', $paylate->order_code) }}" class="btn btn-primary">Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
            
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
