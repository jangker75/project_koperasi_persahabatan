<x-admin-layout titlePage="{{ $titlePage }}">
    <div class="row">
        <div class="col-12 col-md-7 p-4">
            <div class="card cart">
                <div class="card-header">
                    <h3 class="card-title">Shopping Cart</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-vcenter">
                            <thead>
                                <tr class="border-top">
                                    <th>Product</th>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="bodyCart">
                                <tr>
                                    <td colspan="6">
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
                <div class="card-body p-3">
                    <input type="text" name="scanbarcode" autofocus id="scanBarcode"
                        class="form-control form-control-lg border border-primary" placeholder="Masukan Kode SKU">
                    <div id="scanBarcodeHelp" class="form-text">Scan Barcode atau Ketik Kode SKU Barang untuk menambah
                        barang atau menambah quantity.</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Cart Totals</div>
                </div>
                <div class="card-body py-2">
                    <div class="table-responsive">
                        <table class="table table-borderless text-nowrap mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-start">Sub Total</td>
                                    <td class="text-end"><span class="fw-bold  ms-auto" id="subtotalAll">Rp 0</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-start">Additional Discount</td>
                                    <td class="text-end"><span class="fw-bold text-success">- Rp 0</span></td>
                                </tr>
                                <tr>
                                    <td class="text-start fs-18">Total Bill</td>
                                    <td class="text-end"><span class="ms-2 fw-bold fs-23" id="total">Rp 0</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <ul class="list-group list-group-flush" id="elementPaylater">
                    <li class="list-group-item">
                        <div class="form-group">
                            <label for="">Pilih Karyawan paylater</label><br>
                            <select class="form-select select2 w-100" aria-label="Default select example" id="mySelect2"
                                name="employee_id">
                            </select>
                        </div>
                    </li>
                </ul>
                <div class="card-footer">
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="paylater" id="buttonPaylater">
                        <span class="custom-control-label">Paylater</span>
                    </label>
                    <div class="btn-list">
                        <div class="btn btn-success float-sm-end" id="buttonCheckout">Check out<i
                                class="fa fa-arrow-right ms-1"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="style">
      <style>
        
        .select2-results__options{
          offset: hidden;
        }
        .select2-container{
          width: 100% !important;
        }
      </style>
    </x-slot>

    <x-slot name="script">
        <script>
          let productInCart = [];
          let subtotal = 0;
          let discount = 0;
          let total = 0;
            $(document).ready(function () {

                $('#elementPaylater').hide()

                $('#buttonPaylater').click(function () {
                    $('#elementPaylater').toggle()
                })
                $('#mySelect2').select2({
                    placeholder: "Masukan NIK / Nama Staff",
                    minimumInputLength: 5,
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
                            // console.log(data)
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

                    const checker = productInCart.find(element => {
                        if (element.sku === value) {
                            element.qty += 1;
                            element.subtotal = element.price * element.qty
                            return true;
                        }

                        return false;
                    });


                    if (checker == undefined) {
                        $.ajax({
                            type: "GET",
                            url: "{{ url('/api/product-by-sku') }}/" + value,
                            cache: "false",
                            data: {
                                'sku': value,
                            },
                            datatype: "html",
                            success: function (response) {
                                let toPush = {
                                    title: response.product.title,
                                    sku: response.product.sku,
                                    price: response.product.price,
                                    qty: 1,
                                    subtotal: response.product.price,
                                    cover: "{{ asset('storage') }}/" + response.product
                                        .cover
                                }
                                productInCart.push(toPush)
                                renderElementCart(productInCart)
                                subtotal = countSubtotal(productInCart);
                                total = subtotal - discount;
                                $('#total').html("Rp " + total)
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
                        renderElementCart(productInCart)
                        subtotal = countSubtotal(productInCart);
                        total = subtotal - discount;
                        $('#total').html("Rp " + total)
                    }


                });
                $('#scanBarcode').keyup(function (e) {
                    if (e.keyCode == 13) {
                        $(this).trigger("enterKey");
                    }
                });


                $('body').on('click', '.delete-cart', function () {
                    let skuNumber = $(this).attr('id');
                    skuNumber = skuNumber.replace("dlt", "");
                    var data = productInCart.filter(function (obj) {
                        return obj.sku !== skuNumber;
                    });
                    // get index of object with id:37
                    var removeIndex = productInCart.map(function (item) {
                        return item.sku;
                    }).indexOf(skuNumber);

                    // remove object
                    productInCart.splice(removeIndex, 1);
                    renderElementCart(productInCart);
                    subtotal = countSubtotal(productInCart);
                    total = subtotal - discount;
                    $('#total').html("Rp " + total)
                });

                $('body').on('click', '.counter', function () {
                    let skuNumber = $(this).closest('.handle-counter').attr('id');
                    skuNumber = skuNumber.replace("sku", "");

                    const checker = productInCart.find(element => {
                        if (element.sku === skuNumber) {
                            if ($(this).hasClass('counter-minus')) {
                                element.qty -= 1;
                            } else if ($(this).hasClass('counter-plus')) {
                                element.qty += 1;
                            }
                            element.subtotal = element.price * element.qty

                            return true;
                        }

                        return false;
                    });
                    renderElementCart(productInCart);
                    subtotal = countSubtotal(productInCart);
                    total = subtotal - discount;
                    $('#total').html("Rp " + total)
                })
            })

            $('#buttonCheckout').click(function(){
              let checkoutValue = {
                item: productInCart,
                discount: discount
              }
              console.log($('#buttonPaylater').is(':checked'));
              if($('#buttonPaylater').is(':checked')){
                checkoutValue.paylater = $("#mySelect2").val()
              }
              console.log(checkoutValue);
            });

            function renderElementCart(items) {
                $('#bodyCart').html("");
                let elementHtml = '';

                items.forEach(product => {
                    elementHtml = elementHtml + `
                  <tr>
                      <td>
                          <div class="text-center">
                              <img src="` + product.cover + `" alt="" class="cart-img text-center">
                          </div>
                      </td>
                      <td>` + product.title + `</td>
                      <td class="fw-bold">` + product.price + `</td>
                      <td>
                          <div class="handle-counter" id="sku` + product.sku + `">
                              <button type="button" class="counter-minus counter btn btn-white lh-2 shadow-none">
                                  <i class="fa fa-minus text-muted"></i>
                              </button>
                              <input type="text" value="` + product.qty + `" class="qty">
                              <button type="button" class="counter-plus counter btn btn-white lh-2 shadow-none">
                                  <i class="fa fa-plus text-muted"></i>
                              </button>
                          </div>
                      </td>
                      <td>` + product.subtotal + `</td>
                      <td>
                          <div class=" d-flex g-2">
                              <a class="btn text-danger bg-danger-transparent btn-icon py-1 delete-cart"
                                  data-bs-toggle="tooltip" data-bs-original-title="Delete" id="dlt` + product.sku + `"><span
                                      class="bi bi-trash fs-16"></span></a>
                          </div>
                      </td>
                  </tr>
                `;

                    $('#bodyCart').html(elementHtml);
                });
            }

            function countSubtotal(item) {
                let sum = 0;

                for (let index = 0; index < item.length; index++) {
                    sum += item[index].subtotal;
                }

                $('#subtotalAll').html("Rp " + sum)
                return sum;
            }

        </script>
    </x-slot>
</x-admin-layout>
