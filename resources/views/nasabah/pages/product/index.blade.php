@extends('nasabah.layout.base-nasabah')

@section('content')
<section class="col-12 p-4" style="background-color: rgb(200, 217, 231);">
    <div class="breadcrumb-style2">
        <ol class="breadcrumb1 m-0 p-0 px-2">
            <li class="breadcrumb-item1"><a href="{{ route('nasabah.home') }}">Home</a></li>
            <li class="breadcrumb-item1 active">Produk</li>
        </ol>
    </div>
</section>
<section class="col-12 p-0 px-2 mb-5">
    <div class="row">
        <div class="col-12">
            <div class="row p-1 px-4 mb-4" style="background-color: rgb(248, 235, 196);">
                <div class="col-6 d-flex align-items-center">
                    <strong class="h5 m-0 fw-bold">Kategori :</strong>
                </div>
                <div class="col-6 d-flex justify-content-end">
                    <div class="btn-group mt-2 mb-2">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">Semua Kategori
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" style="">
                            <li><a href="javascript:void(0)">Semua Kategori</a></li>
                            <li class="divider"></li>
                            @foreach ($categories as $category)
                            <li><a
                                    href="{{ route('nasabah.product.index', ['category' => $category->name]) }}">{{ $category->name }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($product as $prod)
                <div class="col-6 px-2">
                    <div class="card shadow border">
                        <img src="{{ asset('storage/'.$prod->cover) }}" class="card-img-top" alt="">
                        <div class="card-body p-3">
                            <div class="w-100 p-0" style="height: 40px;">
                                <div class="fw-bold">{{ Str::limit($prod->name, 25, '...') }}</div>
                            </div>
                            <div class="fw-bold text-danger mt-3">
                                {{ format_uang($prod->price[count($prod->price) - 1]->revenue) }}</div>
                            <br>
                            <small class="small text-success">Ready on Stock</small>
                            <div class="d-flex w-100 mt-4">
                                <a href="{{ route('nasabah.product.show', $prod->slug) }}"
                                    class="btn btn-primary btn-sm me-2">Lihat Detail</a>
                                <button class="btn btn-outline-primary btn-sm"><i
                                        class="fa fa-shopping-basket"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
    <div class="row">
      <div class="col-12 mb-4">
        <div class="d-flex justify-content-center align-items-center mb-4">
          {{ $product->links() }}
        </div>
      </div>
    </div>
</section>



@endsection

@section('footer')
@include('nasabah.layout.bottombar')
@endsection
