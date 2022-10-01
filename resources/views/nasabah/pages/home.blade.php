@extends('nasabah.layout.base-nasabah')

@section('content')
@if (count($checkDataNasabah) > 0)
<section class="col-12 mt-3">
    <div class="card text-danger bg-danger-transparent card-transparent">
        <div class="card-body">
            <h4 class="card-title"><b>Lengkapi Data Profile Anda</b></h4>
            <p class="card-text">
                <ul>
                    @foreach ($checkDataNasabah as $key => $msg)
                        <li><i class="fa fa-remove"></i>{{ __('employee.'.$key) }} - {{ $msg }}</li>
                    @endforeach
                </ul>
            </p>
        </div>
    </div>
</section>
@endif
<section class="col-12 mt-3">
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
            <a href="{{ route('nasabah.product.index') }}" style="text-decoration: none;color: inherit;">
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

<section class="col-12">
    <div class="row my-3">
        <div class="col-12">
            <div class="row">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="h4 fw-bold">List Produk Toko : </h4>
                    <div class="form-group">
                        <select class="form-select" name="store_id" id="storeId">
                            @foreach ($stores as $store)
                            <option value="{{ $store->id }}">{{ $store->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row" id="products">

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<section class="col-12 my-3 pb-5">
    <img src="" alt="" class="w-100 border rounded" height="120">
</section>


@endsection

@section('footer')
@include('nasabah.layout.bottombar')
@endsection

@section('script')

<script>
    $(document).ready(function () {
        // variable cart and some function espscially refreshCart() has declared in "script-navbar.blade.php"
        let products = [];

        // storeId
        if (sessionStorage.getItem("storeId") !== null) {
            $("#storeId").val(sessionStorage.getItem("storeId"))
        } else {
            $("#storeId").val("{{ $stores[0]->id }}")
        }
        sessionStorage.setItem('storeId', $("#storeId").val())

        // change store
        $("#storeId").change(function () {
            // empty the cart
            cart = [];
            refreshCart()
            sessionStorage.removeItem('storeId');
            sessionStorage.setItem('storeId', $(this).val())
            callRender()
        })

        // -------------------------------------------------------------------------------------------------------------------

        // rendering Page
        callRender()

        function callRender() {
            $.ajax({
                type: "GET",
                url: "{{ url('/api/paginate-product-in-stock-from-store') }}?storeId=" + $("#storeId")
                    .val(),
                cache: "false",
                datatype: "html",
                success: function (response) {
                    products = response.products

                    renderElementProduct(products)
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

        function renderElementProduct(item) {
            $("#products").html()
            let elementHtml = '';
            item.forEach(element => {
                elementHtml = elementHtml + `
              <div class="col-6 px-2">
                <div class="card shadow">
                    <img src="` + "{{ asset('storage') }}/" + element.cover + `" class="card-img-top" alt="">
                    <div class="card-body p-3">
                        <div class="w-100 p-0 mb-2" style="height: 40px;">
                            <div class="fw-bold">` + truncateString(element.title, 20) + `</div>
                        </div>
                        <div
                            class="fw-bold text-danger">Rp ` + formatRupiah(String(element.price)) + `</div>
                        <small class="small text-success">Ready on Stock</small>
                        <div class="d-flex w-100 mt-4">
                            <a href="` + "{{ url('/product') }}/" + element.sku + `"
                                class="btn btn-primary btn-sm me-2 flex-fill">Lihat Detail</a>
                            <button class="btn btn-outline-primary btn-sm btn-add-to-cart"
                                data-sku="` + element.sku + `"><i class="fa fa-shopping-basket"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            `;
            });
            $("#products").html(elementHtml);
        }

        function truncateString(str, num) {
            if (str.length > num) {
                return str.slice(0, num) + "...";
            } else {
                return str;
            }
        }

        // -------------------------------------------------------------------------------------------------------------------

        // add to cart
        $("body").on("click", ".btn-add-to-cart", function () {
            let value = $(this).data("sku")

            const checker = cart.find(element => {
                if (element.sku == value) {
                    element.qty += 1;
                    element.subtotal = element.price * element.qty
                    return true;
                }
                return false;
            });

            if (checker == undefined) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/api/product-by-sku') }}?sku=" + value,
                    cache: "false",
                    datatype: "html",
                    success: function (response) {
                      let toPush = {
                          title: response.product.title,
                          sku: response.product.sku,
                          price: response.product.price,
                          qty: 1,
                          subtotal: response.product.price,
                          cover: "{{ asset('storage') }}/" + response.product.cover
                      }
                      cart.push(toPush);
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

            refreshCart();
        })
    })

</script>
@endsection()
