@extends('nasabah.layout.base-nasabah')

@section('content')

<section class="py-2">
    <select class="form-select" name="store_id" id="storeId">
        @foreach ($stores as $store)
        <option value="{{ $store->id }}">{{ $store->name }}</option>
        @endforeach
    </select>
</section>
<section class="col-12 p-0 px-2 mb-5">
    <div class="row">
        <div class="col-12">
            <div class="row p-1 px-4 mb-4" style="background-color: rgb(248, 235, 196);">
                <div class="col-6 d-flex align-items-center">
                    <span class="fw-bold">Pilih Kategori :</span>
                </div>
                <div class="col-6 d-flex justify-content-end">
                    <div class="btn-group mt-2 mb-2">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <span id="buttonCategory">Semua Kategori</span>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" style="height:50vh; overflow: scroll;">
                            <li data-id="0" class="category"><a>Semua Kategori</a></li>
                            {{-- <li class="divider"></li> --}}
                            @foreach ($categories as $category)
                            <li data-id="{{ $category->id }}" class="category"><a>{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row" id="products"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>page : <span id="pageNumber"></span></div>
                <div>
                    <button class="btn border bg-white page-control" data-action="previous">previous page</button>
                    <button class="btn border bg-white page-control" data-action="next">next page</button>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="my-5 py-5"></section>



@endsection

@section('footer')
@include('nasabah.layout.bottombar')
@endsection

@section('script')
<script>
    $(document).ready(function () {
      // variable cart and some function espscially refreshCart() has declared in "script-navbar.blade.php"
        let products = [];
        let categoryId = 0;
        let pages = 1;

        // store
        if (sessionStorage.getItem("storeId") !== null) {
            $("#storeId").val(sessionStorage.getItem("storeId"))
        } else {
            $("#storeId").val("{{ $stores[0]->id }}")
        }
        sessionStorage.setItem('storeId', $("#storeId").val())
        $("#storeId").change(function () {
            cart = [];
            refreshCart()
            sessionStorage.removeItem('storeId');
            sessionStorage.setItem('storeId', $(this).val())
            callRender()
        })

        // pagination
        $("#pageNumber").html(pages);
        
        $(".page-control").click(function () {
            let action = $(this).data('action');
            if (action == "previous") {
                if (pages > 1) {
                    pages--;
                }
            } else {
                pages++;
            }

            $("#pageNumber").html(pages);
            callRender();
        })


        // category
        $('.category').click(function () {
            let id = $(this).data('id')
            $('#buttonCategory').html($(this).html())
            categoryId = id;
            callRender()
        })

        // rendering html
        callRender()
        function renderElementProduct(item) {
            $("#products").html()
            let elementHtml = '';
            item.forEach(element => {
                elementHtml = elementHtml + `
                <div class="col-6 px-2">
                    <div class="card shadow border">
                        <img src="` + "{{ asset('storage') }}/" + element.cover + `" class="card-img-top" alt="">
                        <div class="card-body p-1">
                            <div class="w-100 p-0" style="height: 40px;">
                                <div class="fw-bold">` + truncateString(element.title, 20) + `</div>
                            </div>
                            <div class="fw-bold text-danger mt-3">Rp 
                                ` + formatRupiah(String(element.price)) + `</div>
                            <small class="small text-success">Ready on Stock : ` + element.stock + `</small>
                            <div class="d-flex w-100 mt-4">
                                <a href="` + "{{ url('product') }}/" + element.sku + `"
                                    class="btn btn-primary btn-sm me-2 flex-fill">Lihat Detail</a>
                                <button class="btn btn-outline-primary btn-sm btn-add-to-cart" data-sku="` + element
                    .sku + `"><i
                                        class="fa fa-shopping-basket"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
              `;
            });
            $("#products").html(elementHtml)
        }

        function callRender() {
            let url = "{{ url('/api/paginate-product-in-stock-from-store') }}?storeId=" + $("#storeId").val() +
                "&page=" + pages

            if (categoryId !== 0) {
                url = url + "&categoryId=" + categoryId;
            }

            $.ajax({
                type: "GET",
                url: url,
                cache: "false",
                datatype: "html",
                success: function (response) {
                    products = response.products
                    if (products.length > 0) {
                        renderElementProduct(products)
                    } else {
                        swal({
                            title: "Gagal",
                            text: "Halaman Sudah berakhir",
                            type: "error"
                        });
                        pages--;
                        $("#pageNumber").html(pages);
                    }
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

        // add-to-cart
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

            refreshCart()
        })
    })

</script>
@endsection
