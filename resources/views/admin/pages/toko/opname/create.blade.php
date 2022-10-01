<x-admin-layout titlePage="{{ $titlePage }}">

    <section class="col-12">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Info Opname</div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-12 col-md-2">
                                Pilih Lokasi Toko :
                            </div>
                            <div class="col-12 col-md-10">
                                <select name="storeId" class="form-control form-select"
                                    data-bs-placeholder="Masukan Sumber Toko" id="storeId">
                                    @foreach ($stores as $store)
                                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-12 col-md-2">
                                Tambahkan Catatan :
                            </div>
                            <div class="col-12 col-md-10">
                                <textarea name="note" class="form-control" id="note"
                                    placeholder="Tambahkan Catatan Opname" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Detail Item Opname</div>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control product-input mb-4"
                            placeholder="Input nama produk atau sku untuk menambah produk">
                        <div class="position-relative">
                            <div class="card card-search-product position-absolute border border-dark p-2">
                                <ul class="list-group list-group-flush data-list-product p-0">
                                    <li class="list-group-item product-show p-2">testdad</li>
                                </ul>
                            </div>
                        </div>
                        <div class="table-responsive">
                          <table class="table table-bordered">
                              <thead class="table-primary fw-bold text-uppercase">
                                  <th>Nama Produk</th>
                                  <th>Selisih yang ditemukan</th>
                                  <th>Tipe</th>
                                  <th>Expired</th>
                                  <th>keterangan</th>
                                  <th>Action</th>
                              </thead>
                              <tbody id="bodyTable">
                                  <tr>
                                      <td colspan="5" class="text-center">Belum ada produk yang ditambahkan</td>
                                  </tr>
                                  {{--  --}}
                              </tbody>
                          </table>
                        </div>
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
            let storeId = "{{ $stores[0]->id }}";
            let order = [];
            let note = "";
            let employeeId = "{{ auth()->user()->employee->id }}"

            $("#storeId").change(function () {
                storeId = $(this).val()
            })

            $("#note").keyup(function(){
              note = $(this).val()
            })

            $(".card-search-product").hide();
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
                let code = String(Date.now());
                let element = AddElement({
                    id: dataId,
                    name: keyword,
                    code: code
                })

                if (order.length == 0) {
                    $("#bodyTable").html("")
                }
                $("#bodyTable").append(element)

                let toPush = {
                    productId: $(this).data('product-id'),
                    quantity: 1,
                    type: "minus",
                    isExpired: false,
                    description: "",
                    code: code
                }
                order.push(toPush)
                
                $(".product-input").val("")
                $(this).closest(".card-search-product").hide();
                $(this).remove();
            })

            function AddElement(product) {
                let elementHtml = `
                  <tr data-id="` + product.id + `" data-code="` + product.code + `">
                    <td>` + product.name + `</td>
                    <td>
                      <input type="number" name="quantity" value="1" class="form-control qtyProduct" placeholder="Masukan Jumlah Temuan">
                    </td>
                    <td>
                      <select name="type" class="form-control form-select typeSelect" data-bs-placeholder="Pilih Tipe" id="type">
                          <option value="minus">Minus</option>
                          <option value="plus">Plus</option>
                      </select>
                    </td>
                    <td>
                      <input type="checkbox" name="isExpired" class="checkboxExpired" id="">
                      <label for="">Expired?</label>
                    </td>
                    <td>
                      <textarea type="text" name="description" class="form-control descriptionItem" rows="2" placeholder="Tambahkan Keterangan"></textarea>
                    </td>
                    <td>
                      <div class="btn btn-danger fw-bold btn-delete-row">&times;</div>
                    </td>
                  </tr>
              `;

                return elementHtml
            }

            $("body").on("click", ".btn-delete-row", function () {
                let id = $(this).closest("tr").data("id")
                let code = $(this).closest("tr").data("code")
                var data = order.filter(function (obj) {
                    return obj.code !== code;
                });
                // get index of object with id:37
                var removeIndex = order.map(function (item) {
                    return item.code;
                }).indexOf(code);

                // remove object
                order.splice(removeIndex, 1);
                $(this).closest("tr").remove()
                
            })

            $("body").on("change", ".qtyProduct", function () {
                if (parseInt($(this).val()) < 1) {
                    swal({
                        title: "Gagal",
                        text: "Jumlah tidak boleh 0",
                        type: "error"
                    });
                    $(this).val(1);
                    return false;
                }

                let quantity = $(this).val();
                let productId = $(this).closest("tr").data('id');
                let productCode = $(this).closest("tr").data('code');
                const checker = order.find(element => {
                    if (element.code == productCode) {
                        element.quantity = parseInt(quantity)
                        return true;
                    }
                    return false;
                });
                
            })

            $("body").on("change", ".typeSelect", function () {
                let type = $(this).val();
                console.log(type)
                let productId = $(this).closest("tr").data('id');
                let productCode = $(this).closest("tr").data('code');
                const checker = order.find(element => {
                    if (element.code == productCode) {
                        element.type = type
                        return true;
                    }
                    return false;
                });
                
            })

            $("body").on("change", ".checkboxExpired", function () {
                // console.log()
                let isExpired = $(this).is(":checked");
                let productId = $(this).closest("tr").data('id');
                let productCode = $(this).closest("tr").data('code');
                const checker = order.find(element => {
                    if (element.code == productCode) {
                        element.isExpired = isExpired
                        return true;
                    }
                    return false;
                });
                
            })

            $("body").on("keyup", ".descriptionItem", function () {
                let description = $(this).val();
                let productId = $(this).closest("tr").data('id');
                let productCode = $(this).closest("tr").data('code');
                const checker = order.find(element => {
                    if (element.code == productCode) {
                        element.description = description
                        return true;
                    }
                    return false;
                });
                
            })

            $("#submit").click(function(){
              let value = {
                storeId: storeId,
                employeeId: employeeId,
                note: note,
                item:order
              }
    
              console.log(value)
              $.ajax({
                    type: "POST",
                    processData: false,
                    contentType: 'application/json',
                    cache: false,
                    url: "{{ url('/api/opname') }}",
                    data: JSON.stringify(value),
                    dataType: "json",
                    enctype: 'multipart/form-data',
                    success: function (response) {
                      swal({
                          title: "Sukses",
                          text: response.message,
                          type: "success"
                      });
                        
                        setTimeout(function () {
                            window.location.replace("{{ url('admin/toko/opname') }}");
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
