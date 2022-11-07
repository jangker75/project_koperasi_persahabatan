<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fw-bold">{{ str("Form untuk Return Barang Supplier")->title() }}</h3>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-4">
                                    <label for="supplierId" class="fw-bold">Pilih Supplier Tujuan</label>
                                    <select class="form-select" name="supplier_id" id="supplierId"
                                        placeholder="Pilih Supplier">
                                        @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-4">
                                    <label for="note" class="fw-bold">Catatan</label>
                                    <textarea name="note" id="note" class="form-control" rows="4"
                                        placeholder="Masukan Catatan"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="fw-bold">Konfigurasi Produk</div>
                            <div class="card-body p-3 position-relative">
                                <input type="text" name="scanbarcode" autofocus id="scanBarcode"
                                    class="form-control form-control-sm border-primary" placeholder="Masukan Kode SKU">
                                <div id="scanBarcodeHelp" class="form-text text-small">Scan Barcode atau Ketik Kode SKU
                                    Barang untuk
                                    menambah
                                    barang atau menambah quantity.</div>
                                <div class="position-absolute w-100">
                                    <div class="card position-absolute border border-primary" id="resultSearchProduct"
                                        style="min-height: 12vh; z-index:99;" id="bodyResultSearchProduct">
                                        <a href="" class="border d-flex">
                                            <img src="http://127.0.0.1:8000/storage/default-image.jpg"
                                                class="card-img-top" alt="" style="width: 60px;">

                                            <div class="p-2 ms-2">
                                                <div class="fw-bold text-dark">Lorem ipsum dolor sit amet.</div>
                                                <div class="fw-bold text-danger">Rp 10000</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table text-uppercase table-bordered">
                                    <thead class="table-primary">
                                        <th>Foto</th>
                                        <th>Produk</th>
                                        <th>Harga Beli</th>
                                        <th>Jumlah</th>
                                        <th>Deskripsi</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody id="bodyTable">
                                        <tr>
                                            <td colspan="6" class="text-center">Belum ada produk</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="submit" class="btn btn-primary w-100 mt-4">Submit Data</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="scriptVendor">
        <script src="{{ asset('/assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    </x-slot>

    @slot('script')
    <script>
        $(document).ready(function () {
            let productInCart = [];
            let supplierId = "{{ $suppliers[0]->id }}";
            let note = "--";

            $("#supplierId").change(function () {
                supplierId = $(this).val();
            })

            $("#note").change(function () {
                note = $(this).val();
            })

            $('input[name=checkAll]').change(function () {
                if (this.checked) {
                    $(".checkSingle").each(function () {
                        this.checked = true;
                    });
                } else {
                    $(".checkSingle").each(function () {
                        this.checked = false;
                    });
                }
            })

            $("#resultSearchProduct").hide();

            listProductInSearch = [];
            $("#scanBarcode").keyup(function () {

                let keyword = $(this).val();
                let storeId = 1;

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
                        listProductInSearch = response.product
                        renderSearchResult(listProductInSearch);
                    },
                    error: function (xhr, status, error) {
                        console.log(error)
                    }
                });
            })

            function renderSearchResult(data) {
                $("#resultSearchProduct").html("")
                data.forEach(element => {
                    let html = `<div class="border d-flex search-click" data-sku="` + element
                        .productSKU + `">
                        <img src="{{ url('storage') }}/` + element.productCover + `" class="card-img-top"
                                  alt="" style="width: 60px;">
                        <div class="p-2">
                          <div class="fw-bold text-dark">` + truncateString(element.productName, 24) + `</div>
                          <div class="fw-bold text-danger">` + formatRupiah(String(element.price), 'Rp ') + `</div>
                        </div>
                      </div>`;

                    $("#resultSearchProduct").append(html)
                    $('#resultSearchProduct').show()
                });
            }

            $("body").on("click", ".search-click", function () {
                let value = String($(this).data('sku'))
                $("#scanBarcode").val(null)
                if (productInCart.length == 0) {
                    $('#bodyCart').html("")
                }

                const checker = productInCart.find(element => {
                    if (element.sku === value) {
                        return element;
                    }

                    return false;
                });

                if (checker == undefined) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('/api/product-by-sku') }}?sku=" + value + "&storeId=1",
                        cache: "false",
                        datatype: "html",
                        success: function (response) {
                          console.log(response)
                            let toPush = {
                                id: response.product.id,
                                title: response.product.title,
                                sku: response.product.sku,
                                price: response.product.price,
                                description: "",
                                qty: 1,
                                discount: 0,
                                subtotal: response.product.price,
                                stock: response.product.stock,
                                cover: "{{ asset('storage') }}/" + response.product
                                    .cover

                            }
                            renderRowTable(toPush);
                            productInCart.push(toPush)

                        },
                        error: function (xhr, status, error) {
                            swal({
                                title: "Gagal",
                                text: "Produk tidak ditemukan atau stock sedang kosong",
                                type: "error"
                            });
                        }
                    });
                } else {
                    swal({
                        title: "Gagal",
                        text: "Produk sudah ditambahkan",
                        type: "error"
                    });
                }

                $("#resultSearchProduct").html("")
                $("#resultSearchProduct").hide();
            })

            function renderRowTable(data) {
                if (productInCart.length == 0) {
                    $("#bodyTable").html("")
                }

                let html = `
                <tr class="rowItem" data-id="` + data.id + `">
                  <td>
                    <img src="` + data.cover + `"
                      height="48" class="img-thumbnail" style="height: 48px;" alt="">
                  </td>
                  <td>
                    ` + truncateString(data.title, 20) + `
                  </td>
                  <td>
                    ` + formatRupiah(String(data.price)) + `
                  </td>
                  <td>
                    <input type="number" name="quantity" min="1" class="form-control" data-id="` + data.id +
                    `" value="` + data.qty + `" id="">
                  </td>
                  <td>
                    <input type="text" name="description" class="form-control" data-id="` + data.id + `" placeholder="masukan deskripsi" id="">
                  </td>
                  <td>
                    <div class="btn btn-danger btn-sm btn-delete" data-id="` + data.id + `">
                      <i class="bi bi-trash"></i>
                    </div>
                  </td>
                </tr>
              `;

                $("#bodyTable").append(html)
            }

            function truncateString(str, num) {
                if (str.length > num) {
                    return str.slice(0, num) + "...";
                } else {
                    return str;
                }
            }

            $('body').on('change', "input[name=quantity]", function(){
                let id = $(this).data("id")
                let value = $(this).val();
                const checker = productInCart.find(element => {
                    if (element.id === id) {
                        element.qty = value;
                    }
                });
            })
            $('body').on('change', "input[name=description]", function(){
                let id = $(this).data("id")
                let value = $(this).val();
                const checker = productInCart.find(element => {
                    if (element.id === id) {
                        element.description = value;
                    }
                });
            })

            $("body").on("click", ".btn-delete", function () {
                let id = $(this).data("id")

                const indexOfObject = productInCart.findIndex(object => {
                    return object.id === id;
                });

                productInCart.splice(indexOfObject, 1);

                $(".rowItem[data-id="+id+"]").remove()

                console.log(productInCart)
            })

            $("#submit").click(function(){
              let payload = {
                supplier_id: supplierId,
                submit_employee_id: "{{ auth()->id() }}",
                note: note,
                items: productInCart
              }

              console.log(payload);

              $.ajax({
                  type: "POST",
                  processData: false,
                  contentType: 'application/json',
                  cache: false,
                  url: "{{ url('/api/return-supplier') }}",
                  data: JSON.stringify(payload),
                  dataType: "json",
                  enctype: 'multipart/form-data',
                  success: function (response) {
                      if (response.status) {
                          swal({
                              title: "Sukses",
                              text: response.message,
                              type: "success"
                          });
                      }
                      
                      setTimeout(function () {
                          window.location.replace("{{ route('admin.return-supplier.index') }}");
                      }, 1000)
                  },
                  error: function (response) {
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
