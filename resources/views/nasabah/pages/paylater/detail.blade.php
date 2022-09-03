@extends('nasabah.layout.base-nasabah')

@section('content')
<section class="py-4 bg-white">
    <div class="d-flex align-items-center">
        <a href="{{ route('nasabah.history-paylater') }}" class="btn fw-bold h5 m-0">
            <i class="fa fa-angle-left text-muted"></i>
        </a>
        <h1 class="h3 fw-bold m-0">Detail Paylater</h1>
    </div>
</section>
<section class="col-12 py-4" style="min-height: 95vh;">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Kode Order : <strong class="fw-bold">{{ $order->order_code }}</strong></div>
        </div>
        <div class="card-body p-4">
          <div class="row">
            <div class="col-6 mb-4">
              <div class="text-sm mb-2">Total Harga</div>
              <div class="h3">{{ format_uang($order->total) }}</div>
            </div>
            <div class="col-6 mb-4">
              <div class="text-sm mb-2">status paylater</div>
              <div class="btn btn-info btn-sm" title="{{ $order->transaction->statusPaylater->description }}">{{ $order->transaction->statusPaylater->name }}</div>
            </div>
            <div class="col-6 mb-4">
              <div class="text-sm mb-2">Tanggal Permintaan</div>
              <div>{{ $order->transaction->request_date }}</div>
            </div>
            <div class="col-6 mb-4">
              <div class="text-sm mb-2">Tanggal Persetujuan</div>
              <div>{{ $order->transaction->approval_date }}</div>
            </div>
          </div>
        </div>
    </div>
    <div class="card">
      <div class="card-header">
        <div class="card-title">Detail Order</div>
      </div>
      <div class="card-body p-2 ">
        @foreach ($order->detail as $detail)
        <div class="row border-bottom p-2 pb-4">
          <div class="col-12 h5">{{ $detail->product_name }}</div>
          <div class="col-6 h5 m-0">
            {{ format_uang($detail->price) }} x {{ $detail->qty }}
          </div>
          <div class="col-6 h5 m-0 fw-bold">
            {{ format_uang($detail->subtotal) }}
          </div>
        </div>
        @endforeach
      </div>
      <div class="card-footer h4">Total : {{ format_uang($order->total) }}</div>
    </div>
</section>


@endsection

{{-- @section('footer')
@include('nasabah.layout.bottombar')
@include('admin.pages.employee.history_balance_modal')
@endsection --}}
{{-- @push('script')
@include('admin.pages.employee.history_balance_modal_script')
@endpush --}}
