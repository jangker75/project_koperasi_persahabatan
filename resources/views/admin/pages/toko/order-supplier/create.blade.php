<x-admin-layout titlePage="{{ $titlePage }}">

    <section class="col-12">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Formulir Order Supplier</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="supplier">Toko Supplier</label>
                                    <select name="supplier" class="form-control form-select select2"
                                        data-bs-placeholder="Masukan Sumber Toko" id="supplier">
                                        @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">
                                            {{ $supplier->name . " - " . $supplier->contact_name . " - " .  $supplier->contact_phone }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
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
                            <div class="col-6">
                              <label for="">Catatan Pembelian</label>
                              <textarea name="note" id="note" rows="6" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Item Order Supplier</div>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control product-input mb-4"
                            placeholder="Input nama produk atau sku untuk menambah produk">
                        <div class="position-relative">
                            <div class="card card-search-product position-absolute border border-dark p-2">
                                <ul class="list-group list-group-flush data-list-product p-0 border" 
                                style="max-height:16em; overflow-y:scroll; --webkit-scrollbar-button: blue;">
                                    <li class="list-group-item product-show p-2">testdad</li>
                                </ul>
                            </div>
                        </div>
                        <table class="table table-bordered">
                            <thead class="table-primary fw-bold text-uppercase">
                                <th>Nama Produk</th>
                                <th>Jumlah</th>
                                <th>Unit Pembelian</th>
                                <th>Action</th>
                            </thead>
                            <tbody id="bodyTable">
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada Item Terdaftar</td>
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
            let supplierId = "{{ $suppliers[0]->id }}";
            let destinationStoreId = "{{ $stores[0]->id }}";
            let order = [];
            let employeeId = "{{ auth()->user()->employee->id }}"
            let note = ""

            function AddElement(product) {
                let elementHtml = `
                  <tr data-id="` + product.id + `">
                    <td>` + product.name + `</td>
                    <td>
                      <input type="number" class="form-control quantity-input" required placeholder="Masukan Jumlah Pembelian">
                    </td>
                    <td>
                      <input type="text" class="form-control request-unit" required placeholder="Unit pembelian">
                    </td>
                    <td>
                        <div class="btn btn-danger fw-bold btn-delete-row">&times;</div>
                    </td>
                  </tr>
              `;

                return elementHtml
            }

            $("#supplier").val(supplierId)
            $("#destinationStore").val(destinationStoreId)
            $(".card-search-product").hide();

            $("#supplier").change(function () {
                supplierId = $(this).val()
            })
            $("#destinationStore").change(function () {
                destinationStoreId = $(this).val()
            })
            $("#note").keyup(function(){
              note = $(this).val()
            })


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

                    let url = "{{ url('/api/search-product-stock-zero') }}";
                    let param = {
                        keyword: keyword
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
                                        .productName + "</li>")
                                } else {
                                    console.log("asdasdsad");
                                }
                            });
                        },
                        error: function (xhr, status, error) {
                            ul.html(
                                "<li class='list-group-item product-hide p-2'>Produk tidak ditemukan (click untuk menghilangkan ini)</li>"
                                )
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
                    if (order.length == 0) {
                        $("#bodyTable").html("")
                    }
                    $("#bodyTable").append(element)

                    let toPush = {
                        productId: $(this).data('product-id'),
                        quantity: 0,
                        unit: ''
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
                console.log(order)
            })

            $("body").on("keyup", ".request-unit", function () {
                let unit = $(this).val();
                let productId = $(this).closest("tr").data('id');
                const checker = order.find(element => {
                    if (element.productId === productId) {
                        element.unit = unit
                        return true;
                    }
                    return false;
                });
                console.log(order)
            })

            $("#submit").click(function () {
                if (order.length < 1) {
                    swal({
                        title: "Gagal",
                        text: "Belum ada produk yang ditambahkan",
                        type: "error"
                    });
                    return false;
                }

                order.forEach(element => {
                    if (element.quantity < 1) {
                        swal({
                            title: "Gagal",
                            text: "semua jumlah harus di isi",
                            type: "error"
                        });
                        return false;
                    }

                    if (element.unit == '') {
                        swal({
                            title: "Gagal",
                            text: "semua unit harus diisi",
                            type: "error"
                        });
                        return false;
                    }
                });

                let checkoutValue = {
                    supplierId: supplierId,
                    destinationStore: destinationStoreId,
                    product: order,
                    employeeId: employeeId,
                    note: note
                }
                console.log(checkoutValue)

                $.ajax({
                    type: "POST",
                    processData: false,
                    contentType: 'application/json',
                    cache: false,
                    url: "{{ url('/api/order-supplier') }}",
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
                            window.location.replace("{{ url('admin/toko/order-supplier') }}");
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
