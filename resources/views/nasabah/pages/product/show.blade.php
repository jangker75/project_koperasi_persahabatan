@extends('nasabah.layout.base-nasabah')

@section('content')
<section class="col-12 p-4" style="background-color: rgb(200, 217, 231);">
    <div class="breadcrumb-style2">
        <ol class="breadcrumb1 m-0 p-0 px-2">
            <li class="breadcrumb-item1"><a href="{{ route('nasabah.home') }}">Home</a></li>
            <li class="breadcrumb-item1"><a href="{{ route('nasabah.product.index') }}">Product</a></li>
            <li class="breadcrumb-item1 active">#{{ $product->sku }}</li>
        </ol>
    </div>
</section>
<section class="col-12 p-2">
    <div class="row">
        <div class="col-12 py-4">
            <div class="card">
                <div class="card-body">
                    <img src="{{ asset('storage/'. $product->cover) }}" alt="" class="w-100 mb-4 img-thumbnail">
                    <h1 class="h3 fw-bold">{{ $product->name }}</h1>
                    <h1 class="h3 fw-bold text-danger">
                        {{ format_uang($product->price[count($product->price) - 1]->revenue) }}
                    </h1>
                    <div class="mb-4">
                        <span class="h4 fw-bold">Deskripsi</span><br>
                        {!! $product->description !!}
                    </div>
                    <div class="mb-4">
                      <div class="table-responsive">
                        <div class="h4 fw-bold">Informasi Produk</div>
                          <table class="table table-striped table-bordered">
                              <tbody>
                                  <tr>
                                      <td class="fw-bold">{{ __('product.name') }}</td>
                                      <td>{{ $product->name }}</td>
                                  </tr>
                                  <tr>
                                      <td class="fw-bold">{{ __('product.sku') }}</td>
                                      <td>{{ $product->sku }}</td>
                                  </tr>
                                  <tr>
                                      <td class="fw-bold">{{ __('product.unit_measurement') }}</td>
                                      <td>{{ $product->unit_measurement }}</td>
                                  </tr>
                                  <tr>
                                      <td class="fw-bold">{{ __('product.price') }}</td>
                                      <td>{{ format_uang($product->price[count($product->price) - 1]->revenue) }}
                                      </td>
                                  </tr>
                                  <tr>
                                      <td class="fw-bold">{{ __('product.brand') }}</td>
                                      <td>
                                          @if (isset($product->brand->name))
                                          {{ $product->brand->name }}
                                          @else
                                          --
                                          @endif
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>



@endsection

@section('footer')
@include('nasabah.layout.bottombar-product')
@endsection
