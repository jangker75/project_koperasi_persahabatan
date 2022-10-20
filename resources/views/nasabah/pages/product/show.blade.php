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
        </ol>
    </div>
</section>
<section class="col-12 p-2">
    <div class="row">
        <div class="col-12 py-4">
            <div class="card">
                <div class="card-body" id="bodyCard">

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
        // variable cart and some function espscially refreshCart() has declared in "script-navbar.blade.php"
        let products = [];
        let productSku = "{{ request()->segment(count(request()->segments())) }}"

        if (Cookies.get("storeId") !== null) {
            $("#storeId").val(Cookies.get("storeId"))
        } else {
            $("#storeId").val("{{ $stores[0]->id }}")
        }
        Cookies.set('storeId', $("#storeId").val())
        $("#storeId").change(function () {
            cart = [];
            refreshCart()
            Cookies.remove('storeId');
            Cookies.set('storeId', $(this).val())
            callRender()
        })


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

        // button add to cart
        $("#addToCart").click(function () {
            quantityToAdd = $('.qty').val()
            const checker = cart.find(element => {
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
                    qty: parseInt(quantityToAdd),
                    subtotal: product.price * parseInt(quantityToAdd),
                    cover: "{{ asset('storage') }}/" + product.cover
                }

                cart.push(toPush);
            }

            refreshCart()
            swal({
                title: "Success",
                text: "Produk berhasil ditambahkan",
                type: "success"
            });
        })
    })

</script>
@endsection
