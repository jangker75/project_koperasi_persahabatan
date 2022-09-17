<x-admin-layout titlePage="{{ $titlePage }}">

    <section class="col-12">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Formulir Transfer Stock</div>
                    </div>
                    <div class="card-body">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="originStore">Asal Toko</label>
                                <select name="originStore" class="form-control form-select"
                                    data-bs-placeholder="Masukan Sumber Toko" id="originStore">
                                    @foreach ($stores as $store)
                                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="destinationStore">Tujuan Toko</label>
                                <select name="destinationStore" class="form-control form-select"
                                    data-bs-placeholder="Masukan Sumber Toko" id="destinationStore">
                                    @foreach ($stores as $store)
                                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Item Transfer Stock</div>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control product-input mb-4" placeholder="Input nama produk atau sku untuk menambah produk">
                        <div class="position-relative">
                            <div
                                class="card card-search-product position-absolute border border-dark p-2">
                                <ul class="list-group list-group-flush data-list-product p-0">
                                    <li class="list-group-item product-show p-2">testdad</li>
                                </ul>
                            </div>
                        </div>
                        <table class="table table-bordered">
                            <thead class="table-primary fw-bold text-uppercase">
                                <th>Nama Produk</th>
                                <th>Jumlah yang diminta</th>
                                <th>Action</th>
                            </thead>
                            <tbody id="bodyTable">
                                <tr>
                                  <td colspan="3" class="text-center">Belum ada produk yang ditambahkan</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <button class="btn btn-primary w-100" id="submit">Buat Tiket Transfer Stock</button>
            </div>
        </div>
    </section>

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
            let storeId = "{{ $transferStock->from_store_id }}";
            let destinationStoreId = "{{ $transferStock->to_store_id }}";
            let order = [];
            let employeeId = "{{ auth()->user()->employee->id }}"

            function AddElement(product){
              let elementHtml = `
                  <tr data-id="` + product.id + `">
                    <td>` + product.name + `</td>
                    <td><input type="number" class="form-control quantity-input"
                            placeholder="Ketik Jumlah Produk"></td>
                    <td>
                        <div class="btn btn-danger fw-bold btn-delete-row">&times;</div>
                    </td>
                  </tr>
              `;

              return elementHtml
            }

            function renderingElement(product){
              let elementHtml = `
                  <tr data-id="` + product.id + `">
                    <td>` + product.name + `</td>
                    <td><input type="number" class="form-control quantity-input"
                            placeholder="Ketik Jumlah Produk" value="`+product.quantity+`"></td>
                    <td>
                        <div class="btn btn-danger fw-bold btn-delete-row">&times;</div>
                    </td>
                  </tr>
              `;

              return elementHtml
            }

            $("#originStore").val(storeId)
            $("#destinationStore").val(destinationStoreId)
            $(".card-search-product").hide();

            $("#originStore").change(function () {
                storeId = $(this).val()
            })
            $("#destinationStore").change(function () {
                destinationStoreId = $(this).val()
            })

            function renderElement(arrayOrder){
              $("#bodyTable").html("");

              arrayOrder.forEach(element => {
                let elementHtml = renderingElement({
                  id: element.productId,
                  name: element.title,
                  quantity: element.quantity
                })

                $("#bodyTable").append(elementHtml);
              });
            }

            $.ajax({
                  type: "GET",
                  url: "{{ url('api/transfer-stock-items') }}/{{ $transferStock->id }}",
                  dataType: "json",
                  enctype: 'multipart/form-data',
                  processData: false,
                  contentType: 'application/json',
                  cache: false,
                  success: function (response) {
                      console.log(response)
                      order = response.detailItem
                      renderElement(order)

                  },
                  error: function (xhr, status, error) {
                      ul.html(
                          "<li class='list-group-item product-hide p-2'>Produk tidak ditemukan (click untuk menghilangkan ini)</li>")
                  }
              });



            $("body").on("click", ".btn-delete-row", function () {
                let id = $(this).closest("tr").data("id")
                var data = order.filter(function (obj) {
                    return obj.productId !== id;
                });
                // get index of object with id:37
                var removeIndex = order.map(function (item) {
                    return item.productId;
                }).indexOf(id);

                // remove object
                order.splice(removeIndex, 1);
                $(this).closest("tr").remove()
                console.log(order)
            })

            $("body").on("keyup", ".product-input", function () {
                let keyword = $(this).val()
                if (keyword.length >= 3) {

                    let element = $(this).siblings(".position-relative").find(".card-search-product");
                    element.show();

                    let ul = element.find(".data-list-product");
                    ul.html("");

                    let url = "{{ url('/api/search-product') }}";
                    let param = {
                        keyword: keyword,
                        notInListProduct: '',
                        originStore: storeId
                    }
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
                            products = response.product
                            products.forEach(element => {
                                if ($('*[data-product-id="' + element.productId +
                                        '"]').length == 0) {
                                    ul.append(
                                        "<li class='list-group-item product-show p-2' data-product-id='" +
                                        element.productId + "'>" + element
                                        .productName + " (stocks : " + element
                                        .qty + ") </li>")
                                }else{
                                  console.log("asdasdsad");
                                }
                            });

                        },
                        error: function (xhr, status, error) {
                            ul.html(
                                "<li class='list-group-item product-hide p-2'>Produk tidak ditemukan (click untuk menghilangkan ini)</li>")
                        }
                    });

                }
            })

            $("body").on("click", ".product-hide", function () {
                $(this).closest(".card-search-product").hide();
            })

            $("body").on("click", ".product-show", function () {
                let keyword = $(this).text()
                
                let dataId = $(this).data('product-id');
                const checker = order.find(element => {
                    if (element.productId === dataId) {
                        return true;
                    }
                    return false;
                });
                console.log(checker)
                if (checker == undefined) {
                    let element = AddElement({
                      id: dataId,
                      name: keyword
                    })

                    // console.log()
                    if(order.length == 0){
                      $("#bodyTable").html("")
                    }
                    $("#bodyTable").append(element)

                    let toPush = {
                        productId: $(this).data('product-id'),
                        quantity: 0
                    }
                    order.push(toPush)
                } else {
                    swal({
                        title: "Gagal",
                        text: "Masukan Produk lain",
                        type: "error"
                    });
                }
                $(".product-input").val("")
                $(this).closest(".card-search-product").hide();
                $(this).remove();
                console.log(order)
            })

            $("body").on("keyup", ".quantity-input", function () {
                let quantity = $(this).val();
                let productId = $(this).closest("tr").data('id');
                const checker = order.find(element => {
                    if (element.productId === productId) {
                        element.quantity = parseInt(quantity)
                        return true;
                    }
                    return false;
                });
            })

            $("#submit").click(function(){
              if (order.length < 1) {
                    swal({
                        title: "Gagal",
                        text: "Belum ada produk yang ditambahkan",
                        type: "error"
                    });
                    return false;
                }

                let checkoutValue = {
                    originStore: storeId,
                    destinationStore: destinationStoreId,
                    product: order,
                    employeeId: employeeId,
                    "_method": 'put'
                }

                $.ajax({
                    type: "POST",
                    processData: false,
                    contentType: 'application/json',
                    cache: false,
                    url: "{{ url('/api/transfer-stock') }}/{{ $transferStock->id }}",
                    data: JSON.stringify(checkoutValue),
                    dataType: "json",
                    enctype: 'multipart/form-data',
                    success: function (response) {
                      swal({
                          title: "Sukses",
                          text: response.message,
                          type: "success"
                      });
                        
                        setTimeout(function () {
                            window.location.replace("{{ url('admin/toko/management-stock') }}/{{ $transferStock->id }}");
                        }, 1000)
                    },
                    error: function (response) {
                      console.log(response)
                        swal({
                            title: "Gagal",
                            text: response.message,
                            type: "error"
                        });
                    }
                });
            })
        })

    </script>
    @endslot
</x-admin-layout>
