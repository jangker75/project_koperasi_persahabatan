@extends('nasabah.layout.base-nasabah')

@section('content')
<section class="py-2">
    <select class="form-select" name="store_id" id="storeId">
        @foreach ($stores as $store)
        <option value="{{ $store->id }}">{{ $store->name }}</option>
        @endforeach
    </select>
</section>
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
                <div class="card-body" id="bodyCard">
                    {{-- <img src="{{ asset('storage/'. $product->cover) }}" alt="" class="w-100 mb-4 img-thumbnail">
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
                    </div> --}}
                </div>
            </div>

        </div>
    </div>
</section>



@endsection

@section('footer')
@include('nasabah.layout.bottombar-product')
@endsection

@section('script')
<script>
    $(document).ready(function () {
        let productInCart = [];
        let subtotal = 0;
        let discount = 0;
        let total = 0;
        let products = [];
        let productSku = "{{ request()->segment(count(request()->segments())) }}"

        if (sessionStorage.getItem("storeId") !== null) {
            $("#storeId").val(sessionStorage.getItem("storeId"))
        } else {
            $("#storeId").val("{{ $stores[0]->id }}")
        }

        sessionStorage.setItem('storeId', $("#storeId").val())

        $("#storeId").change(function () {
            productInCart = [];
            refreshCart(productInCart)
            sessionStorage.removeItem('storeId');
            sessionStorage.setItem('storeId', $(this).val())
            setTimeout(refreshQuantityCart, 1000);
            callRender()
        })
        
        if (sessionStorage.getItem('cart') !== null) {
            productInCart = JSON.parse(sessionStorage.getItem("cart"))
        }

        function countSubtotal(item) {
            let sum = 0;
            for (let index = 0; index < item.length; index++) {
                sum += item[index].subtotal;
            }
            return sum;
        }

        function refreshCart(item) {
            setTimeout(function () {
                sessionStorage.removeItem('cart');
                sessionStorage.setItem('cart', JSON.stringify(item))
            }, 500);
            setTimeout(function () {
                sessionStorage.removeItem('total');
                sessionStorage.setItem('total', total)
            }, 500);
        }

        // render html
        callRender();

        function callRender() {
            let url = "{{ url('/api/product-by-sku') }}?sku=" + productSku + "&storeId=" + $("#storeId").val()

            $.ajax({
                type: "GET",
                url: url,
                cache: "false",
                datatype: "html",
                success: function (response) {
                    console.log(response)
                    product = response.product
                    renderElementProduct(product)
                },
                error: function (xhr, status, error) {
                    swal({
                        title: "Gagal",
                        text: "Produk tidak ditemukan",
                        type: "error"
                    });
                }
            });
        }

        function renderElementProduct(items) {
            $('#bodyCard').html("");

            let elementHtml = `
              <img src="` + "{{ asset('storage') }}/" + items.cover + `" alt="" class="w-100 mb-4 img-thumbnail">
              <h1 class="h3 fw-bold">` + items.title + `</h1>
              <h1 class="h3 fw-bold text-danger">
                  ` + formatRupiah(String(items.price), "Rp") + `
              </h1>
              <div class="mb-4">
                  <span class="h4 fw-bold">Deskripsi</span><br>
                  ` + items.description + `
              </div>
              <div class="mb-4">
                  <div class="table-responsive">
                      <div class="h4 fw-bold">Informasi Produk</div>
                      <table class="table table-striped table-bordered">
                          <tbody>
                              <tr>
                                  <td class="fw-bold">Nama Produk</td>
                                  <td>` + items.title + `</td>
                              </tr>
                              <tr>
                                  <td class="fw-bold">SKU / UPC</td>
                                  <td>` + items.sku + `</td>
                              </tr>
                              <tr>
                                  <td class="fw-bold">Unit Pembelian</td>
                                  <td>` + items.unit_measurement + `</td>
                              </tr>
                              <tr>
                                  <td class="fw-bold">Stok Produk</td>
                                  <td>` + items.stock + `
                                  </td>
                              </tr>
                              <tr>
                                  <td class="fw-bold">Harga Produk</td>
                                  <td>` + formatRupiah(String(items.price), "Rp") + `
                                  </td>
                              </tr>
                              <tr>
                                  <td class="fw-bold">Brand Produk</td>
                                  <td>
                                      ` + items.brandName + `
                                  </td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
              </div>
            `;

            $('#bodyCard').html(elementHtml);
        }

        // counter
        let qty = 1
        $('.counter').click(function () {
            if ($(this).hasClass("counter-plus")) {
                qty++;
                $('.qty').val(qty);
            } else {
                if (qty > 1) {
                    qty--;
                    $('.qty').val(qty);
                }
            }
        })

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        // button add to cart
        $("#addToCart").click(function () {
            console.log(productInCart)
            quantityToAdd = $('.qty').val()
            console.log(quantityToAdd)
            const checker = productInCart.find(element => {
                if (element.sku == productSku) {
                    element.qty = parseInt(element.qty) + parseInt(quantityToAdd);
                    element.subtotal = parseInt(element.price) * parseInt(element.qty)
                    return true;
                }
                return false;
            });

            if (checker == undefined) {
                let toPush = {
                    title: product.title,
                    sku: product.sku,
                    price: product.price,
                    qty: 1,
                    subtotal: product.price,
                    cover: "{{ asset('storage') }}/" + product.cover
                }

                subtotal = countSubtotal(productInCart);
                total = subtotal - discount;
                productInCart.push(toPush);
            }

            refreshCart(productInCart)
            setTimeout(refreshQuantityCart, 1000);
            swal({
                title: "Success",
                text: "Produk berhasil ditambahkan",
                type: "success"
            });
            window.location = "{{ url('/product') }}"
            console.log(checker)
        })
    })

</script>
@endsection
