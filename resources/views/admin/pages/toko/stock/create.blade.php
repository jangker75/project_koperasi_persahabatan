<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
      @if (isset($transferStock))
      <form action="{{ route('admin.management-stock.update', $transferStock->id) }}" method="post">
        @csrf        
        @method('put')
      @else
        <form action="{{ route('admin.management-stock.store') }}" method="post">
        @csrf        
      @endif
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="w-100 row">
                        <div class="col-md-6">
                            <div class="w-100  p-3">
                                <h4 class="h4 fw-bold">Formulir untuk Transfer Stock</h4>
                                <div class="form-group">
                                    <label for="originStore">Origin Store</label>
                                    <select name="originStore" class="form-control form-select select2"
                                        data-bs-placeholder="Masukan Sumber Toko" id="originStore">
                                        @foreach ($stores as $store)
                                        <option value="{{ $store->id }}"
                                          @if (isset($transferStock))
                                            @if ($transferStock->from_store_id == $store->id)
                                              selected
                                            @endif
                                          @endif
                                          >{{ $store->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="destinationnStore">Destination Store</label>
                                    <select name="destinationStore" class="form-control form-select select2"
                                        data-bs-placeholder="Masukan Tujuan Toko">
                                        @foreach ($stores as $store)
                                        <option value="{{ $store->id }}"
                                          @if (isset($transferStock))
                                            @if ($transferStock->to_store_id == $store->id)
                                              selected
                                            @endif
                                          @endif
                                          >{{ $store->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="w-100">
                        <h1 class="h4">Input Produk</h1>
                        <div class="table-responsive">
                            <table class="table w-100 table-bordered">
                                <thead class="table-primary">
                                    <th>Produk</th>
                                    <th>Jumlah</th>
                                    <th>Unit</th>
                                    <th>Action</th>
                                </thead>
                                <tbody id="bodyTable">
                                  @if (isset($transferStock))
                                  @foreach ($transferStock->DetailItem as $item)
                                  <tr class="rowList">
                                      <td>
                                          <input type="text" class="product-list form-control" name="product[]"
                                              id="product" placeholder="Input Nama Produk" autocomplete="off" value="{{ $item->product->name }}">
                                          <div class="card card-search-product">
                                              <ul class="list-group list-group-flush data-list-product"
                                                  id="dataListProduct">
                                                  <li class="list-group-item product-show">test</li>
                                              </ul>
                                          </div>
                                      </td>
                                      <td><input type="number" class="quantity-list form-control" name="quantity[]"
                                              id="quantity" placeholder="Input Jumlah Produk" value="request_qty"></td>
                                      <td>
                                        <select name="unit[]" class="form-control form-select" >
                                            <option value="pcs">pcs</option>
                                            <option value="pack">pack (6 pcs)</option>
                                            <option value="box">Kardus</option>
                                        </select>
                                      </td>
                                      <td>
                                          <span class="btn btn-danger deleteRows">&times;</span>
                                          <span class="btn btn-primary addRows">&plus;</span>
                                      </td>
                                  </tr>
                                  @endforeach

                                  @else
                                  
                                  <tr class="rowList">
                                      <td>
                                          <input type="text" class="product-list form-control" name="product[]"
                                              id="product" placeholder="Input Nama Produk" autocomplete="off">
                                          <div class="card card-search-product">
                                              <ul class="list-group list-group-flush data-list-product"
                                                  id="dataListProduct">
                                                  <li class="list-group-item product-show">test</li>
                                              </ul>
                                          </div>
                                      </td>
                                      <td><input type="number" class="quantity-list form-control" name="quantity[]"
                                              id="quantity" placeholder="Input Jumlah Produk"></td>
                                      <td>
                                        <select name="unit[]" class="form-control form-select" >
                                            <option value="pcs">pcs</option>
                                            <option value="pack">pack (6 pcs)</option>
                                            <option value="box">Kardus</option>
                                        </select>
                                      </td>
                                      <td>
                                          <span class="btn btn-danger deleteRows">&times;</span>
                                          <span class="btn btn-primary addRows">&plus;</span>
                                      </td>
                                  </tr>
                                  @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Submit Data</button>
        </form>
    </div>

    <x-slot name="styleVendor">
        <style>
            .product-show {
                cursor: pointer;
            }

            .product-show:hover {
                background-color: #e8f3fd;
            }

        </style>
    </x-slot>

    <x-slot name="scriptVendor">
        <script src="{{ asset('/assets/plugins/fileuploads/js/fileupload.js') }}"></script>
        <script src="{{ asset('../assets/plugins/select2/select2.full.min.js') }}"></script>
    </x-slot>

    @slot('script')
    <script>
        $(document).ready(function () {
            let originStore = $("#originStore").val();
            let listProduk = [];

            $('.card-search-product').hide()
            $('.select2').select2({
                minimumResultsForSearch: '',
                width: '100%'
            });
            $("body").on("click", ".addRows", function () {
                let element = $(this).closest(".rowList").html();
                element = `<tr class="rowList">` + element + `</tr>`;
                $("#bodyTable").append(element);
            })
            $("body").on("click", ".deleteRows", function () {
                var numItems = $('.rowList').length;
                if (numItems > 1) {
                    $(this).closest(".rowList").remove();
                }
            })

            $("select[name='originStore']").change(function () {
                let value = $(this).val();
                originStore = value;
            })


            $("#originStore").change(function () {
                let value = $(this).val()
                originStore = val();
            })

            // $("body").on("focusout",".product-list",function(){
            //   $(this).siblings(".card-search-product").hide();
            // })

            $("body").on("keyup", ".product-list", function () {
                let value = ""

                value = $(this).val()
                if (value.length > 4) {
                    let datas;
                    let element = $(this).siblings(".card-search-product");
                    element.find(".data-list-product").html("");

                    let ajax = $.ajax({
                        type: "post",
                        url: "{{ url('/api/search-product') }}",
                        dataType: "json",
                        data: {
                            originStore: originStore,
                            notInListProduct: listProduk,
                            keyword: value
                        },
                        success: function (response) {
                            datas = response.product;
                            if (datas[0] !== undefined) {
                                $.each(datas, function (k, data) {
                                    if (data.productName !== undefined) {
                                        if ($('*[data-product-id="' + data.productId + '"]').length == 0) {
                                            let isid = `<li class="list-group-item product-show" data-product-id="` + data.productId + `">` + data.productName + `</li>`;
                                            element.find(".data-list-product").append(isid)
                                        }
                                    }
                                })
                            } else {
                                let isid = `<li class="list-group-item product-show">Tidak ada Produk yg dimaksud</li>`;
                                element.find(".data-list-product").html(isid)
                            }
                        }
                    });

                    element.show();
                }

                function searchData(keyword){
                  let ajax = $.ajax({
                      type: "post",
                      url: "{{ url('/api/search-product') }}",
                      dataType: "json",
                      data: {
                          originStore: originStore,
                          notInListProduct: listProduk,
                          keyword: keyword
                      },
                      success: function (response) {
                          return response
                      }
                  });
                }

            })

            $("body").on("click", ".product-show", function () {
                let nameProduct = $(this).html();
                let idProduct = $(this).data("product-id")
                if (listProduk.indexOf(idProduct) !== -1) {
                    alert("Produk ini sudah di pilih sebelumnya.")
                } else {
                    // listProduk.push(idProduct)
                    if(idProduct !== ""){
                      $(this).closest(".card-search-product").siblings(".product-list").val(nameProduct)
                    }
                    $(this).closest(".card-search-product").hide();
                    $(".data-list-product").html("")
                }
            })

        })

    </script>
    @endslot
</x-admin-layout>
