@extends('nasabah.layout.base-nasabah')

@section('content')
{{-- <section class="col-12 mt-3 min-vh-100">
    
</section> --}}
<section class="col-12 mt-3 min-vh-100">
    <img src="" alt="" class="w-100 border rounded p-0 mb-2" height="120">
    <div class="d-flex justify-content-between">
        <small>...</small>
        <small>lihat semua promo</small>
    </div>
    <div class="row p-2">
        <div class="col-6 mb-3">
            <a href="{{ route('nasabah.loan-submission.index') }}" style="text-decoration: none;color: inherit;">
                <div class="card shadow py-5">
                    <div class="card-body text-center">
                        <div class="counter-icon bg-primary-gradient box-shadow-secondary num-counter mx-auto">
                            <i class="fa fa-usd" style="height: 27px; width: 27px"></i>
                        </div>
                        <h5>Pengajuan Pinjaman</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 mb-3">
            <a href="#" style="text-decoration: none;color: inherit;">
            <div class="card shadow py-5">
                <div class="card-body text-center">
                    <div class="counter-icon bg-warning-gradient box-shadow-secondary num-counter mx-auto">
                        <i class="fa fa-usd" style="height: 27px; width: 27px"></i>
                    </div>
                    <h5>Pesan Toko Online</h5>
                </div>
            </div>
            </a>
        </div>
    </div>
</section>

{{-- <section class="col-12">
    <div class="row my-3">
        <div class="col-12">
            <div class="row">
                <h4 class="h4 fw-bold">Promo Tahun Ini</h4>
                @foreach ($product as $prod)
                <div class="col-6 px-2">
                    <div class="card shadow">
                        <img src="{{ asset('storage/'.$prod->cover) }}" class="card-img-top" alt="">
                        <div class="card-body p-3">
                            <div class="w-100 p-0 mb-2" style="height: 40px;">
                              <div class="fw-bold">{{ Str::limit($prod->name, 25, '...') }}</div>
                            </div>
                            <span class="fw-bold text-danger">{{ format_uang($prod->price[count($prod->price) - 1]->revenue) }}</span> <br>
                            <small class="small text-success">Ready on Stock</small> 
                            <div class="d-flex w-100 mt-4">
                              <a href="{{ route('nasabah.product.show', $prod->slug) }}" class="btn btn-primary btn-sm me-2">Lihat Detail</a>
                              <button class="btn btn-outline-primary btn-sm"><i class="fa fa-shopping-basket"></i></button>
                            </div>
                        </div>
                        
                    </div>
                  </div>
                @endforeach
            </div>
        </div>
    </div>
</section> --}}
{{-- <section class="col-12 my-3">
    <img src="" alt="" class="w-100 border rounded" height="120">
</section> --}}


@endsection

@section('footer')
  @include('nasabah.layout.bottombar')
@endsection
