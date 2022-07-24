@extends('nasabah.layout.base-nasabah')

@section('content')


  <section class="col-12 mt-3">
    <img src="" alt="" class="w-100 border rounded" height="120">
    <div class="d-flex justify-content-between">
      <small>...</small>
      <small>lihat semua promo</small>
    </div>
  </section>
  <section class="col-12 mt-3">
    <div class="row p-2">
      <div class="col-4 mb-3">
        <div class="card shadow py-5"></div>
      </div>
      <div class="col-4 mb-3">
        <div class="card shadow py-5"></div>
      </div>
      <div class="col-4 mb-3">
        <div class="card shadow py-5"></div>
      </div>
      <div class="col-4 mb-3">
        <div class="card shadow py-5"></div>
      </div>
      <div class="col-4 mb-3">
        <div class="card shadow py-5"></div>
      </div>
    </div>
  </section>

  <section class="col-12">
    <div class="row my-3">
      <h4 class="h4 fw-bold">Promo Tahun Ini</h4>
      @foreach ($product as $prod)
      <div class="col-6 mb-3">
        <div class="card shadow">
          <img src="{{ asset('assets/images/media/12.jpg') }}" class="card-img-top" alt="">
          <div class="card-body">
            <div class="card-title fw-bold">{{ str($prod->name)->title() }}</div>
            <span class="text-danger">Rp. 9000</span>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </section>
  <section class="col-12 my-3">
    <img src="" alt="" class="w-100 border rounded" height="120">
  </section>
  <section class="col-12">
    <div class="row my-3">
      <h4 class="h4 fw-bold">Bahan Masak</h4>
      @foreach ($product as $prod)
      <div class="col-6 mb-3">
        <div class="card shadow">
          <img src="{{ asset('assets/images/media/12.jpg') }}" class="card-img-top" alt="">
          <div class="card-body">
            <div class="card-title fw-bold">{{ str($prod->name)->title() }}</div>
            <span class="text-danger"><strong>Rp. 9000</strong></><br>
            <small class="text-secondary">Harga per {{ $prod->unit_measurement }}</small>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </section>
  <section class="col-12">
    <div class="row my-3">
      <h4 class="h4 fw-bold">Kebutuhan Bayi dan Susu anak</h4>
      @foreach ($product as $prod)
      <div class="col-6 mb-3">
        <div class="card shadow">
          <img src="{{ asset('assets/images/media/12.jpg') }}" class="card-img-top" alt="">
          <div class="card-body">
            <div class="card-title fw-bold">{{ str($prod->name)->title() }}</div>
            <span class="text-danger">Rp. 9000</span>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </section>

@endsection