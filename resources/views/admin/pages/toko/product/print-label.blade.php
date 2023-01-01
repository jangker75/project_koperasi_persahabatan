<x-admin-layout titlePage="{{ $titlePage }}">
    <div class="row row-sm">
        <div class="col-lg-12">
            <a href="{{ route('admin.product.index') }}" class="btn btn-danger mb-4">Kembali</a>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span class="card-title">{{ $titlePage }}</span>
                </div>
                <div class="card-body">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item" >
                            <h2 class="accordion-header" id="headingOne" data-mode="category">
                                <button class="accordion-button text-uppercase" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Pilih kategori untuk print
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row align-items-center">
                                        <div class="col-10">
                                            <div class="d-flex flex-wrap">
                                                @foreach ($categories as $category)
                                                <div class="categories" data-id="{{ $category->id }}">
                                                    {{ $category->name }}</div>
                                                @endforeach
                                            </div>
                                            <small class="text-danger">*hanya bisa maksimal 3 kategori</small><br>
                                            <button class="btn btn-primary my-4">Pilih Kategori</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item" >
                            <h2 class="accordion-header" id="headingTwo" data-mode="product">
                                <button class="accordion-button collapsed text-uppercase" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                    aria-controls="collapseTwo">
                                    Pilih beberapa produk
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <input type="text" name="scanbarcode" autofocus id="scanBarcode"
                                        class="form-control form-control-sm border-primary"
                                        placeholder="Masukan Nama Produk / Kode SKU" autocomplete="off">
                                    <div class="position-relative">
                                        <div class="position-absolute w-100">
                                            <div class="card position-absolute border border-primary"
                                                id="resultSearchProduct"
                                                style="min-height: 12vh; max-height: 48vh; z-index:99; overflow-y: scroll; display:none;">
                                                <span class="border d-flex">
                                                    <img src="http://127.0.0.1:8000/storage/default-image.jpg"
                                                        class="card-img-top" alt="" style="width: 60px;">

                                                    <div class="p-2 ms-2">
                                                        <div class="fw-bold text-dark">Lorem ipsum dolor sit amet.</div>
                                                        <div class="fw-bold text-danger">Rp 10000</div>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="d-flex flex-wrap" id="bodyCart">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @slot('style')
    <style>
        .categories {
            background-color: rgb(238, 238, 238);
            border: 1px solid rgb(99, 99, 99);
            padding: 8px 12px;
            margin: 2px;
            cursor: pointer;
            border-radius: 8px;
            color: #000;
        }

        .categories.selected {
            background-color: #9fa5e2;
            border: 1px solid #4a52a8;
            color: #fff;
        }

    </style>
    @endslot
    @slot('script')
    @include('admin.pages.toko.product.index-script-datatable-label')
    <script>
      var productInCart = [];
      let pickCategory = [];
      let mode = "category";
        $(document).ready(function () {
            $('.accordion-header').click(function(){
                mode = $(this).data('mode');
                pickCategory = [];
                productInCart = [];
                $("#bodyCart").html("");
                $(".categories").removeClass("selected")
            })


            $('.categories').click(function () {
                let id = $(this).data('id')

                if ($(this).hasClass('selected')) {
                    let index = pickCategory.indexOf(id);
                    pickCategory.splice(index, 1);
                    $(this).toggleClass('selected');
                } else {
                    if (pickCategory.length < 3) {
                        pickCategory.push(id)
                        $(this).toggleClass('selected');
                    } else {
                        alert("maksimal hanya 3 kategori yang dipilih");
                    }
                }
                console.log(pickCategory)
            })


            listProductInSearch = [];
            $("#scanBarcode").keyup(function (e) {
                if (e.keyCode == 13) {
                    $("body>#resultSearchProduct").hide();
                    $(this).trigger("enterKey");
                } else {
                    let keyword = $(this).val();
                    let storeId = $("#storeId").val();
                    if (isNaN(parseInt(keyword))) {
                        if (keyword.length > 1) {
                            let url = "{{ url('/api/search-product') }}";
                            let param = {
                                keyword: keyword,
                                notInListProduct: '',
                                originStore: storeId
                            }
                            console.log('params')
                            $.ajax({
                                type: "POST",
                                url: url,
                                data: JSON.stringify(param),
                                dataType: "json",
                                enctype: 'multipart/form-data',
                                processData: false,
                                contentType: 'application/json',
                                cache: false,
                                success: function (response) {
                                    console.log(response);
                                    listProductInSearch = response.product
                                    renderSearchResult(listProductInSearch);
                                },
                                error: function (xhr, status, error) {
                                    let data = {}
                                    renderSearchResult(data, false);
                                    console.log(error)
                                }
                            });
                        }
                    }
                }
            })

            $("body").on('click', '.product-item', function(){
                    let idNumber = $(this).data('id');
                    var removeIndex = productInCart.map(function (item) {
                        return item.id;
                    }).indexOf(idNumber);

                    // remove object
                    productInCart.splice(removeIndex, 1);
                    // $(".product-item[data-id='" + idNumber + "']").remove();
                    $(this).remove();
                    console.log(productInCart)
                })

            $("body").on("click", ".search-click", function () {
                if ($(this).hasClass("close-click")) {
                    $("#resultSearchProduct").html("")
                    $("#resultSearchProduct").hide();
                } else {
                    let value = String($(this).data('id'))
                    $("#scanBarcode").val(null)
                    if (productInCart.length == 0) {
                        $('#bodyCart').html("")
                    }

                    const checker = productInCart.find(element => {
                        if (element.id == value) {
                            return element;
                        }

                        return false;
                    });

                    if (checker == undefined) {
                        let toPush = {
                          id: $(this).data('id'),
                          title: $(this).data('title')
                        }
                        productInCart.push(toPush);
                        renderRowCart(toPush);
                    } 

                    $("#resultSearchProduct").html("")
                    $("#resultSearchProduct").hide();
                    console.log(productInCart)
                }

            })

            function truncateString(str, num) {
                if (str.length > num) {
                    return str.slice(0, num) + "...";
                } else {
                    return str;
                }
            }

            function renderSearchResult(data, success = true) {
                $("#resultSearchProduct").html("")
                if (success == true) {
                    data.forEach(element => {
                        let html = `<div class="border d-flex search-click" data-title="` + element
                            .productName + `" data-id="` + element.productId + `">
                              <img src="{{ url('image') }}/` + element.productCover + `" class="card-img-top"
                                        alt="" style="width: 60px;">
                              <div class="p-2">
                                <div class="fw-bold text-dark">` + truncateString(element.productName, 24) + `</div>
                                <div class="fw-bold text-danger">` + formatRupiah(String(element.price), 'Rp ') + `</div>
                              </div>
                            </div>`;

                        $("#resultSearchProduct").append(html)
                    });
                } else {
                    let html = `<div class="border d-flex search-click close-click">
                              <div class="p-4" style="text-align: center;">produk tidak ditemukan atau stok kosong</div>
                            </div>`;

                    $("#resultSearchProduct").append(html)
                }
                $('#resultSearchProduct').show()
            }

            function renderRowCart(product) {
                if (productInCart.length == 0) {
                    $('#bodyCart').html("")
                }

                let html = `
                  <div class="btn btn-outline-primary mx-1 product-item" data-id="`+product.id+`">`+product.title+`</div>
                `;
                $('#bodyCart').append(html)
            }
        })

    </script>
    @endslot
</x-admin-layout>
