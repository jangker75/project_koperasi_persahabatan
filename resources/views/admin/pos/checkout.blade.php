<x-admin-kasir-component titlePage="{{ $titlePage }}">
    <div class="row">
        <div class="col-12 col-md-7 p-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-2">
                            <a href="{{ url('/admin/dashboard') }}"
                                class="btn btn-sm w-100 bg-danger-transparent">Kembali</a>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-success btn-sm w-100 bg-success-gradient" id="btnReport" data-bs-toggle="modal"
                                data-bs-target="#modalReport">Report</button>
                            <div class="modal fade" id="modalReport" tabindex="-1" style="display: none;"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Laporan Penjualan Hari Ini</h5>
                                            <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                              <div class="col-6 h5 fw-bold text-success">
                                                Jumlah Transaksi : <span id="countOrder">0</span>
                                              </div>
                                              <div class="col-6 h5 fw-bold text-success">
                                                Total Pendapatan : <span id="sumTotalPrice">Rp 0</span> 
                                              </div>
                                              <div class="col-12 my-2">
                                                <div class="h5 mb-2">Jenis Transaksi</div>
                                                <table class="table table-bordered">
                                                  <thead class="table-primary">
                                                    <tr>
                                                      <th>Jenis</th>
                                                      <th>Jumlah Transaksi</th>
                                                      <th>Total Pendapatan</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody id="transactionReport">
                                                    <tr>
                                                      <td colspan="3" align="center">Belum ada transaksi</td>
                                                    </tr>
                                                  </tbody>
                                                </table>
                                              </div>
                                              <div class="col-12 my-2">
                                                <div class="h5 mb-2">Produk Terjual</div>
                                                <table class="table table-bordered">
                                                  <thead class="table-primary">
                                                    <tr>
                                                      <th>Produk</th>
                                                      <th>Jumlah Produk</th>
                                                      <th>Subtotal</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody id="itemReport">
                                                    <tr>
                                                      <td colspan="3" align="center">Belum ada transaksi</td>
                                                    </tr>
                                                  </tbody>
                                                </table>
                                              </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <select class="form-select w-100 form-select-sm" aria-label="Default select example"
                                name="store_id" id="storeId">
                                @foreach ($stores as $store)
                                <option value="{{ $store->id }}">{{ $store->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body p-3 position-relative">
                    <input type="text" name="scanbarcode" autofocus id="scanBarcode"
                        class="form-control form-control-sm border-primary" placeholder="Masukan Kode SKU"
                        autocomplete="off">
                    <div id="scanBarcodeHelp" class="form-text text-small">Scan Barcode atau Ketik Kode SKU Barang untuk
                        menambah
                        barang atau menambah quantity.</div>
                    <div class="position-absolute w-100">
                        <div class="card position-absolute border border-primary" id="resultSearchProduct"
                            style="min-height: 12vh; max-height: 48vh; z-index:99; overflow-y: scroll;">
                            <a href="" class="border d-flex">
                                <img src="http://127.0.0.1:8000/storage/default-image.jpg" class="card-img-top" alt=""
                                    style="width: 60px;">

                                <div class="p-2 ms-2">
                                    <div class="fw-bold text-dark">Lorem ipsum dolor sit amet.</div>
                                    <div class="fw-bold text-danger">Rp 10000</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card cart">
                <div class="card-header p-3">
                    <h3 class="card-title">Shopping Cart</h3>
                </div>
                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-vcenter">
                            <thead>
                                <tr class="border-top">
                                    <th class="fs-10">Product</th>
                                    <th class="fs-10">Title</th>
                                    <th class="fs-10">Price</th>
                                    <th class="fs-10">Quantity</th>
                                    <th class="fs-10">Discount</th>
                                    <th class="fs-10">Subtotal</th>
                                    <th class="fs-10">Action</th>
                                </tr>
                            </thead>
                            <tbody id="bodyCart">
                                <tr>
                                    <td colspan="7">
                                        <div class="text-center">
                                            <div>Belum ada barang yang masuk</div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-12 col-md-5 p-4">
            <div class="card">
                <div class="card-header p-2">
                    <div class="card-title">Cart Totals</div>
                </div>
                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table table-borderless table-sm text-nowrap mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-start">Sub Total</td>
                                    <td class="text-end"><span class="fw-bold  ms-auto" id="subtotalAll">Rp 0</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-start">Additional Discount</td>
                                    {{-- <td class="text-end"><span class="fw-bold text-success">- Rp 0</span></td> --}}
                                    <td class="text-end">
                                        <input type="text" name="discount" id="discount" placeholder="0"
                                            class="form-control form-control-sm">
                                    </td>
                                </tr>
                                <tr class="border bg-success-transparent">
                                    <td class="text-start text-success fw-bold fs-16 p-2">Total Bill</td>
                                    <td class="text-end text-success fw-bold fs-16 p-2"><span class="ms-2 fw-bold"
                                            id="total">Rp 0</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item p-1 border">
                        <div class="row">
                            <div class="col-6 pe-1">
                                <div class="form-group">
                                    <label for="" class="fs-10 m-1">Metode Pembayaran</label><br>
                                    <select class="form-select form-select w-100" aria-label="Default select example"
                                        name="payment_method" id="paymentMethod" value="1">
                                        @foreach ($paymentMethod as $payment)
                                        <option value="{{ $payment->name }}">{{ $payment->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 ps-1">
                                <div class="form-group">
                                    <label for="" class="fs-10 m-1">Pilih Karyawan</label>
                                    <select class="form-select form-select-sm select2 w-100"
                                        aria-label="Default select example" id="mySelect2" name="employee_id">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item p-1 border" id="cash">
                        <div class="form-group">
                            <label for="" class="fs-10 m-1">Jumlah Uang Cash</label><br>
                            <input type="text" name="cash" id="cashInput"
                                class="form-control form-control-sm format-uang" placeholder="Masukan Jumlah uang cash">
                            <div class="row px-4 border">
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-4 p-1">
                                            <div class="btn btn-outline-primary btn-number btn-sm w-100" data-price="1">
                                                1</div>
                                        </div>
                                        <div class="col-4 p-1">
                                            <div class="btn btn-outline-primary btn-number btn-sm w-100" data-price="2">
                                                2</div>
                                        </div>
                                        <div class="col-4 p-1">
                                            <div class="btn btn-outline-primary btn-number btn-sm w-100" data-price="3">
                                                3</div>
                                        </div>
                                        <div class="col-4 p-1">
                                            <div class="btn btn-outline-primary btn-number btn-sm w-100" data-price="4">
                                                4</div>
                                        </div>
                                        <div class="col-4 p-1">
                                            <div class="btn btn-outline-primary btn-number btn-sm w-100" data-price="5">
                                                5</div>
                                        </div>
                                        <div class="col-4 p-1">
                                            <div class="btn btn-outline-primary btn-number btn-sm w-100" data-price="6">
                                                6</div>
                                        </div>
                                        <div class="col-4 p-1">
                                            <div class="btn btn-outline-primary btn-number btn-sm w-100" data-price="7">
                                                7</div>
                                        </div>
                                        <div class="col-4 p-1">
                                            <div class="btn btn-outline-primary btn-number btn-sm w-100" data-price="8">
                                                8</div>
                                        </div>
                                        <div class="col-4 p-1">
                                            <div class="btn btn-outline-primary btn-number btn-sm w-100" data-price="9">
                                                9</div>
                                        </div>
                                        <div class="col-4 p-1">
                                            <div class="btn btn-outline-primary btn-number w-100" data-price="0">
                                                0</div>
                                        </div>
                                        <div class="col-8 p-1">
                                            <div class="btn btn-outline-primary btn-number w-100" data-price="00">
                                                00</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex flex-wrap">
                                        <div class="m-1">
                                            <div class="btn btn-outline-primary btn-cash btn-sm" data-price="5000">Rp
                                                5000</div>
                                        </div>
                                        <div class="m-1">
                                            <div class="btn btn-outline-primary btn-cash btn-sm" data-price="10000">Rp
                                                10.000
                                            </div>
                                        </div>
                                        <div class="m-1">
                                            <div class="btn btn-outline-primary btn-cash btn-sm" data-price="20000">Rp
                                                20.000
                                            </div>
                                        </div>
                                        <div class="m-1">
                                            <div class="btn btn-outline-primary btn-cash btn-sm" data-price="50000">Rp
                                                50.000
                                            </div>
                                        </div>
                                        <div class="m-1">
                                            <div class="btn btn-outline-primary btn-cash btn-sm" data-price="100000">Rp
                                                100.000
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="d-flex justify-content-between align-items-center border p-2 bg-danger-transparent">
                            <div class="fs-16 text-danger fw-bold">Kembalian</div>
                            <div class="fs-16 text-danger fw-bold" id="change">Rp 0</div>
                        </div>
                    </li>
                    <li class="list-group-item p-1 border" id="paymentCode">
                        <div class="form-group">
                            <label for="">Masukan Kode Pembayaran</label><br>
                            <input type="text" name="payment_code" id="paymentCodeInput"
                                class="form-control form-control-sm" placeholder="81723......">
                        </div>
                    </li>
                    {{-- <li class="list-group-item p-1 border" id="elementPaylater">
                        <div class="form-group">
                            <label for="">Pilih Karyawan</label>
                            <select class="form-select form-select-sm select2 w-100" aria-label="Default select example" id="mySelect2"
                                name="employee_id">
                            </select>
                        </div>
                    </li> --}}
                </ul>
                <div class="card-footer p-2">
                    <div class="btn btn-success btn-sm w-100 float-sm-end" id="buttonCheckout">Check out</div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="style">
        <style>
            .select2-results__options {
                offset: hidden;
            }

            .select2-container {
                width: 100% !important;
            }

        </style>
    </x-slot>

    <x-slot name="script">
        <script>
            let productInCart = [];
            let paymentCode = "";
            let subtotal = 0;
            let discount = 0;
            let total = 0;
            let orderBy = "pos";
            let cash = "0";
            let change = 0;

            $(document).ready(function () {

                $("#resultSearchProduct").hide();
                listProductInSearch = [];
                $("#scanBarcode").keyup(function (e) {
                    if (e.keyCode == 13) {
                        $("#resultSearchProduct").hide();
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
                                        listProductInSearch = response.product
                                        console.log(listProductInSearch)
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

                function renderSearchResult(data, success = true) {
                    $("#resultSearchProduct").html("")
                    if (success == true) {
                        data.forEach(element => {
                            let html = `<div class="border d-flex search-click" data-sku="` + element
                                .productSKU + `" data-id="` + element.productId + `">
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
                                element.qty += 1;
                                element.subtotal = element.price * element.qty
                                return element;
                            }

                            return false;
                        });

                        if (checker == undefined) {
                            $.ajax({
                                type: "GET",
                                url: "{{ url('/api/product-by-id') }}?id=" + value +
                                    "&storeId=" +
                                    $("#storeId").val(),
                                cache: "false",
                                datatype: "html",
                                success: function (response) {
                                    let toPush = {
                                        id: parseInt(response.product.id),
                                        title: response.product.title,
                                        sku: response.product.sku,
                                        price: response.product.price,
                                        qty: 1,
                                        discount: 0,
                                        subtotal: response.product.price,
                                        stock: response.product.stock,
                                        cover: response.product.cover

                                    }
                                    setTimeout(() => {
                                        productInCart.push(toPush)
                                        renderRowCart(toPush)
                                    }, 1000);

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
                            updateSku(checker.sku, "qty", checker.qty, checker.subtotal);
                        }

                        $("#resultSearchProduct").html("")
                        $("#resultSearchProduct").hide();
                        console.log(productInCart)
                    }
                })

                $("body").on("click", ".btn-cash", function () {
                    dataCash = parseInt($(this).data('price'));
                    nowCash = cash.split(".").join("");
                    nowCash == "" ? nowCash = 0 : "";
                    nowCash = parseInt(nowCash);
                    newCash = dataCash + nowCash;
                    cash = formatRupiah(String(newCash));
                    $("#cashInput").val(cash)
                    change = newCash - total;
                    $("#change").html(formatRupiah(String(change), "Rp"))
                })

                $("body").on("click", ".btn-number", function(){
                  let data = String($(this).data('price'));
                  var newCash = cash.split(".").join("");
                  console.log(data, newCash)
                  if(data == "0" || data == "00"){
                    if(newCash != "0"){
                      newCash = newCash+data;
                      cash = formatRupiah(String(newCash))
                      $("#cashInput").val(cash)
                      change = newCash - total;
                      $("#change").html(formatRupiah(String(change), "Rp"))
                    }
                  }else{
                    if(newCash == "0"){
                      newCash = data;
                    }else{
                      newCash = newCash+data;
                    }
                    cash = formatRupiah(String(newCash))
                    $("#cashInput").val(cash)
                    change = newCash - total;
                    $("#change").html(formatRupiah(String(change), "Rp"))
                  }
                })

                $("#storeId").val("{{ $stores[0]->id }}");
                $("#storeId").change(function () {
                    productInCart = [];
                    renderElementCart(productInCart)
                })

                $('#paymentCode').hide()

                $('#buttonPaylater').click(function () {
                    $('#elementPaylater').toggle()
                })

                $('#paymentMethod').change(function () {
                    if ($(this).val() == 'paylater') {
                        // $('#elementPaylater').show()
                        $('#paymentCode').hide()
                        $('#cash').hide()
                    } else if ($(this).val() == 'cash') {
                        // $('#elementPaylater').hide()
                        $('#paymentCode').hide()
                        $('#cash').show()
                    } else {
                        // $('#elementPaylater').hide()
                        $('#paymentCode').show()
                        $('#cash').hide()
                    }
                })

                $("#discount").keyup(function () {
                    if (subtotal - $(this).val() > -1) {
                        discount = $(this).val()
                        total = subtotal - discount
                        $("#total").html("Rp " + formatRupiah(String(total)))
                    } else {
                        swal({
                            title: "Gagal",
                            text: "Discount yang dimasukan tidak boleh melampaui harga",
                            type: "error"
                        });
                    }
                })
                $("body").on("keyup", "#paymentCodeInput", function () {
                    paymentCode = $(this).val()
                })
                $('body').on("keyup", "#cashInput", function () {
                    cash = $(this).val()
                    newCash = parseInt(cash.split(".").join(""));
                    change = newCash - total;

                    $("#change").html(formatRupiah(String(change), "Rp"))
                })

                $('#mySelect2').select2({
                    placeholder: "Masukan NIK / Nama Staff",
                    minimumInputLength: 3,
                    ajax: {
                        url: "{{ url('api/search-employee') }}",
                        type: 'POST',
                        delay: 250,
                        cache: true,
                        contentType: 'application/json',
                        data: function (params) {
                            var query = {
                                keyword: params.term
                            }

                            return JSON.stringify(query);
                        },
                        // data: function (params) {
                        //     var query = [{
                        //         field: 'nik',
                        //         value: params.term
                        //     }]

                        //     return JSON.stringify(query);
                        // },
                        processResults: function (data) {
                            let newArray = data.employee.map(({
                                nik: id,
                                fullname: text
                            }) => ({
                                id,
                                text
                            }));
                            return {
                                results: newArray
                            };
                        }
                    }
                });

                $('#scanBarcode').bind("enterKey", function (e) {
                    let value = $(this).val()
                    $(this).val(null)
                    if (productInCart.length == 0) {
                        $('#bodyCart').html("")
                    }

                    $("#resultSearchProduct").hide();

                    const checker = productInCart.find(element => {
                        if (element.sku === value) {
                            element.qty += 1;
                            element.subtotal = element.price * element.qty
                            return element;
                        }

                        return false;
                    });

                    if (checker == undefined) {
                        $.ajax({
                            type: "GET",
                            url: "{{ url('/api/product-by-sku') }}?sku=" + value + "&storeId=" +
                                $("#storeId").val(),
                            cache: "false",
                            datatype: "html",
                            success: function (response) {
                                let toPush = {
                                    id: parseInt(response.product.id),
                                    title: response.product.title,
                                    sku: response.product.sku,
                                    price: response.product.price,
                                    qty: 1,
                                    discount: 0,
                                    subtotal: response.product.price,
                                    stock: response.product.stock,
                                    cover: response.product.cover

                                }
                                productInCart.push(toPush)
                                renderRowCart(toPush)

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

                        updateById(checker.id, "qty", checker.qty, checker.subtotal);
                    }


                });

                $('body').on('click', '.delete-cart', function () {
                    let idNumber = parseInt($(this).attr('id'));
                    var data = productInCart.filter(function (obj) {
                        return obj.id != idNumber;
                    });
                    // get index of object with id:37
                    var removeIndex = productInCart.map(function (item) {
                        return item.id;
                    }).indexOf(idNumber);

                    // remove object
                    productInCart.splice(removeIndex, 1);
                    $("tr[data-id=" + idNumber + "]").remove();

                    subtotal = countSubtotal(productInCart)
                    total = subtotal - discount;

                    $("#subtotalAll").html("Rp " + formatRupiah(String(subtotal)))
                    $("#total").html("Rp " + formatRupiah(String(total)))
                });

                $('body').on('click', '.counter', function () {
                    let id = $(this).data('id');
                    let dom = $(this);
                    const checker = productInCart.find(element => {
                        if (element.id == id) {
                            if (dom.hasClass('counter-plus')) {
                                if (element.qty < element.stock) {
                                    element.qty += 1;
                                    element.subtotal = (element.price * element.qty) - element
                                        .discount;
                                }
                            } else {
                                if (element.qty > 1) {
                                    element.qty -= 1;
                                    element.subtotal = (element.price * element.qty) - element
                                        .discount;
                                }
                            }
                            return element;
                        }
                        return false;
                    });
                    updateById(id, "qty", checker.qty, checker.subtotal);
                })

                $('body').on('change', '.qty', function () {
                    let id = $(this).data('id');
                    let dom = $(this);
                    const checker = productInCart.find(element => {
                        if (element.id == id) {
                          if(parseInt(dom.val()) <= element.stock){
                            element.qty = parseInt(dom.val());
                            element.subtotal = (element.price * element.qty) - element.discount;
                            
                            return element;
                          }else{
                            swal({
                                title: "Gagal",
                                text: "stok tidak mencukupi",
                                type: "error"
                            });
                            updateById(id, "qty", element.qty, element.subtotal);
                            return false;
                          }
                        }
                        return false;
                    });
                    updateById(id, "qty", checker.qty, checker.subtotal);
                })

                $("body").on("keyup", ".discount", function () {
                    let id = $(this).data("id");
                    // let sku = $(this).data("sku");
                    let value = $(this).val()
                    value = value.replace(".", "");

                    if (value == "") {
                        value = 0;
                    } else {
                        value = parseInt(value)
                    }

                    const checker = productInCart.find(element => {
                        if (element.id == id) {
                            if (value !== 0) {
                                element.discount = value;
                                element.subtotal = (element.price * element.qty) - element
                                    .discount
                                return element;
                            }
                        }

                        return false;
                    });
                    console.log(value);
                    console.log(checker);
                    if (checker !== undefined) {
                        // updateSku(sku, "discount", checker.discount, checker.subtotal);
                        updateById(checker.id, "discount", checker.discount, checker.subtotal);
                    }
                })

                $('#buttonCheckout').click(function () {
                    if (productInCart.length < 1) {
                        swal({
                            title: "Gagal",
                            text: "Belum ada produk yang ditambahkan",
                            type: "error"
                        });
                        return false;
                    }
                    let checkoutValue = {
                        item: productInCart,
                        discount: discount,
                        storeId: $("#storeId").val(),
                        orderBy: orderBy,
                        paymentMethod: $('#paymentMethod').val(),
                        employeeOndutyId: "{{ auth()->user()->employee->id }}",
                        employeeRequester: $("#mySelect2").val(),
                    }
                    if ($('#paymentMethod').val() == 'paylater') {
                        checkoutValue.paylater = $("#mySelect2").val()
                    } else if ($('#paymentMethod').val() !== 'CASH' && $('#paymentMethod').val() !==
                        'paylater') {
                        checkoutValue.paymentCode = paymentCode
                    } else {
                        // setCash = parseInt(cash.replace(".",""));
                        setCash = parseInt(cash.split(".").join(''));
                        if (setCash < total) {
                            swal({
                                title: "Gagal",
                                text: "Cash harus lebih dari total harga",
                                type: "error"
                            });
                            return false;
                        }
                        checkoutValue.cash = setCash;
                    }

                    console.log(checkoutValue);

                    $.ajax({
                        type: "POST",
                        processData: false,
                        contentType: 'application/json',
                        cache: false,
                        url: "{{ url('/api/order') }}",
                        data: JSON.stringify(checkoutValue),
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
                            let cash = $("#cash").val();
                            window.open('{{ url("admin/pos/print-receipt" ) }}/' + response
                                .order
                                .order_code, '', "width=800,height=400");
                            setTimeout(function () {
                                location.reload();
                            }, 1000)
                        },
                        error: function (response) {
                            swal({
                                title: "Gagal",
                                text: response.responseJSON.message,
                                type: "error"
                            });
                        }
                    });
                });

                $("#btnReport").click(function(){
                  let transactionReport = [];
                  let itemReport = [];
                  let amount = [];

                  $.ajax({
                    type: "GET",
                    url: "{{ url('api/report-order-today') }}/" + $("#storeId").val(),
                    success: function(response){
                      if(response.calculate.length > 0 && response.items.length > 0){
                        transactionReport = response.calculate;
                        itemReport = response.items;
  
                        renderTransactionReport(response.calculate);
                        renderItemReport(response.items)
  
                        amount = calculateTotal(response.calculate, 'amount');
                        countOrder = calculateTotal(response.calculate, 'totalOrder')
  
                        $("#countOrder").html(countOrder)
                        $("#sumTotalPrice").html(formatRupiah(String(amount), "Rp"))
                      }
                    }
                  })
                })
            })

            function countSubtotal(item) {
                let sum = 0;

                for (let index = 0; index < item.length; index++) {
                    sum += parseInt(item[index].subtotal);
                }
                return sum;
            }

            function renderRowCart(product) {
                if (productInCart.length == 0) {
                    $('#bodyCart').html("")
                }

                let html = `
                <tr data-sku="` + product.sku + `" data-id="` + product.id + `">
                    <td>
                        <div class="text-center">
                            <img src="{{ url('image') }}/` + product.cover + `" alt="" class="cart-img text-center">
                        </div>
                    </td>
                    <td class="fs-10 fw-bold">` + product.title + `</td>
                    <td class="fw-bold">` + formatRupiah(String(product.price)) + `</td>
                    <td>
                        <div class="handle-counter btn-group-sm" id="sku` + product.sku + `">
                            <button type="button" data-sku="` + product.sku + `" data-id="` + product.id + `" class="counter-minus counter btn btn-sm btn-white lh-2 shadow-none">
                                <i class="fa fa-minus text-muted"></i>
                            </button>
                            <input type="text" value="` + product.qty + `" data-sku="` + product.sku + `" data-id="` +
                    product.id + `" class="qty form-control-sm">
                            <button type="button" data-sku="` + product.sku + `" data-id="` + product.id + `" class="counter-plus counter btn btn-sm btn-white lh-2 shadow-none">
                                <i class="fa fa-plus text-muted"></i>
                            </button>
                        </div>
                        <small class="small text-danger">stock : ` + product.stock + `</small>
                    </td>
                    <td>
                      <input type="text" placeholder="0" class="form-control discount format-uang" 
                      data-sku="` + product.sku + `" data-id="` + product.id + `">
                    </td>
                    <td data-sku="` + product.sku + `" data-id="` + product.id + `" class="subtotal">` + formatRupiah(
                        String(product.subtotal)) + `</td>
                    <td>
                        <div class=" d-flex g-2">
                            <a class="btn text-danger bg-danger-transparent btn-icon py-1 delete-cart"
                                data-bs-toggle="tooltip" data-bs-original-title="Delete" id="` + product.id + `"><span
                                    class="bi bi-trash fs-16"></span></a>
                        </div>
                    </td>
                </tr>
              `;
                $('#bodyCart').append(html)
                subtotal = countSubtotal(productInCart)
                total = subtotal - discount;

                $("#subtotalAll").html("Rp " + formatRupiah(String(subtotal)))
                $("#total").html("Rp " + formatRupiah(String(total)))
            }

            function updateSku(sku, param, value, subtotal) {
                $("." + param + "[data-sku=" + sku + "]").val(value)
                $(".subtotal[data-sku=" + sku + "]").html(formatRupiah(String(subtotal)))

                subtotal = countSubtotal(productInCart)
                total = subtotal - discount;

                $("#subtotalAll").html("Rp " + formatRupiah(String(subtotal)))
                $("#total").html("Rp " + formatRupiah(String(total)))
            }

            function updateById(id, param, value, subtotal) {
                $("." + param + "[data-id=" + id + "]").val(value)
                $(".subtotal[data-id=" + id + "]").html(formatRupiah(String(subtotal)))

                subtotal = countSubtotal(productInCart)
                total = subtotal - discount;

                $("#subtotalAll").html("Rp " + formatRupiah(String(subtotal)))
                $("#total").html("Rp " + formatRupiah(String(total)))
            }

            function truncateString(str, num) {
                if (str.length > num) {
                    return str.slice(0, num) + "...";
                } else {
                    return str;
                }
            }

            function renderTransactionReport(item){
              $("#transactionReport").html("");

              item.forEach(element => {
                let html  = `
                  <tr>
                    <td>` + element.name + `</td>
                    <td>` + element.totalOrder + `</td>
                    <td>` + formatRupiah(String(parseInt(element.amount)), "Rp")  + `</td>
                  </tr>
                `;
                $("#transactionReport").append(html);
              });
            }

            function renderItemReport(item){
              $("#itemReport").html("");

              item.forEach(element => {
                let html  = `
                  <tr>
                    <td>` + element.productName + `</td>
                    <td>` + element.qty + `</td>
                    <td>` + formatRupiah(String(parseInt(element.subtotal)), "Rp")  + `</td>
                  </tr>
                `;
                $("#itemReport").append(html);
              });
            }

            const calculateTotal = (array, column) => {
                let data = array.map(item => parseInt(item[column]));
                const sum = data.reduce((accumulator, current) => accumulator + current);
                return sum;
            };
        </script>
    </x-slot>
</x-admin-kasir-component>
