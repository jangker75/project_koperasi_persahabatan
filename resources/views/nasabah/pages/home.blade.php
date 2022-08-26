@extends('nasabah.layout.base-nasabah')

@section('content')
<section class="col-12 mt-3">
    <img src="" alt="" class="w-100 border rounded p-0 mb-2" height="120">
    <div class="d-flex justify-content-between">
        <small>...</small>
        <small>lihat semua promo</small>
    </div>
</section>
<section class="col-12 mt-3">
    <div class="row p-2">
        <div class="col-6 mb-3">
            <div class="card shadow p-3 bg-info text-white">
                <strong class="fw-bold text-uppercase">Pinjaman</strong>
            </div>
        </div>
        <div class="col-6 mb-3">
            <div class="card shadow p-3 bg-info text-white">
                <strong class="fw-bold text-uppercase">Saldo Nasabah</strong>
            </div>
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
<section class="col-12 my-3">
    <img src="" alt="" class="w-100 border rounded" height="120">
</section>
@endsection

@section('footer')
@include('nasabah.layout.bottombar')
@endsection

@section('script')
<script>
    $(document).ready(function () {
        let productInCart = [];
        let subtotal = 0;
        let discount = 0;
        let total = 0;
        let products = [];

        $("#storeId").val("{{ $stores[0]->id }}")
        callRender()

        $("#storeId").change(function(){
          productInCart = [];
          refreshCart(productInCart)
          setTimeout(refreshCuantityCart, 1000);
          callRender()
        })


        

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
        }

        $("body").on("click", ".btn-add-to-cart",function () {
            let value = $(this).data("sku")

            const checker = productInCart.find(element => {
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

                        subtotal = countSubtotal(productInCart);
                        total = subtotal - discount;
                        productInCart.push(toPush);


                    },
                    error: function (xhr, status, error) {
                        swal({
                            title: "Gagal",
                            text: "Produk tidak ditemukan",
                            type: "error"
                        });
                    }
                });
            } else {
                subtotal = countSubtotal(productInCart);
                total = subtotal - discount;
            }

            refreshCart(productInCart)
            setTimeout(refreshCuantityCart, 1000);
        })

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
                          <span
                              class="fw-bold text-danger">Rp ` + formatRupiah(String(element.price))  + `</span>
                          <br>
                          <small class="small text-success">Ready on Stock</small>
                          <div class="d-flex w-100 mt-4">
                              <a href="` + "{{ url('/product') }}/" + element.id + `"
                                  class="btn btn-primary btn-sm me-2">Lihat Detail</a>
                              <button class="btn btn-outline-primary btn-sm btn-add-to-cart"
                                  data-sku="` + element.sku + `"><i class="fa fa-shopping-basket"></i></button>
                          </div>
                      </div>
                  </div>
              </div>
              `;
            });
            $("#products").html(elementHtml)
        }

        function callRender(){
          $.ajax({
              type: "GET",
              url: "{{ url('/api/paginate-product-in-stock-from-store') }}?storeId=" + $("#storeId").val(),
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

        function truncateString(str, num) {
            if (str.length > num) {
                return str.slice(0, num) + "...";
            } else {
                return str;
            }
        }

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
    })

</script>
@endsection()
