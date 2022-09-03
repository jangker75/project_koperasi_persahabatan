<x-admin-layout titlePage="{{ $titlePage }}">
    <div class="row">
        <div class="col-12 col-md-7 p-4">
            <div class="card cart">
                <div class="card-header">
                    <h3 class="card-title">Detail Pesanan</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-vcenter">
                            <thead>
                                <tr class="border-top">
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="bodyCart">
                                @foreach ($order->detail as $detail)
                                <tr>
                                    <td>{{ $detail->product_name }}</td>
                                    <td>{{ $detail->price }}</td>
                                    <td>{{ $detail->qty }}</td>
                                    <td>{{ $detail->subtotal }}</td>
                                    <td><button class="btn border">&times;</button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-12 col-md-5 p-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        Detail Paylater
                    </div>
                </div>
                <div class="card-body py-2">
                    <div class="table-responsive">
                        <table class="table table-borderless text-nowrap mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-start">Nama Pemohon</td>
                                    <td class="text-end"><span class="fw-bold ms-auto">{{ $order->transaction->requester->full_name }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-start">Tanggal Pemohonan</td>
                                    <td class="text-end"><span class="fw-bold">{{ $order->transaction->request_date }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-start">Status Paylater</td>
                                    <td class="text-end"><div class="btn {{ $order->transaction->statusPaylater->color_button }}">
                                      {{ $order->transaction->statusPaylater->name }}
                                    </div></td>
                                </tr>
                                <tr>
                                    <td class="text-start">Catatan Antar</td>
                                    <td class="text-end">
                                      <textarea name="" id="" class="form-control" rows="3" readonly>{{ $order->note }}</textarea>
                                    </div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Total Harga</div>
                </div>
                <div class="card-body py-2">
                    <div class="table-responsive">
                        <table class="table table-borderless text-nowrap mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-start">Sub Total</td>
                                    <td class="text-end"><span class="fw-bold  ms-auto"
                                            id="subtotalAll">{{ format_uang($order->subtotal) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-start">Additional Discount</td>
                                    {{-- <td class="text-end"><span class="fw-bold text-success">- {{ format_uang($order) }}</span>
                                    </td> --}}
                                    <td class="text-end">
                                        <input type="text" name="discount" id="discount" placeholder="0"
                                            class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-start fs-18">Total Bill</td>
                                    <td class="text-end"><span class="ms-2 fw-bold fs-23"
                                            id="total">{{ format_uang($order->total) }}</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
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
            .select2-results__options {
                offset: hidden;
            }

            .select2-container {
                width: 100% !important;
            }

        </style>
    </x-slot>

    {{-- <x-slot name="script">
        <script>
            let productInCart = [];
            let paymentCode = "";
            let subtotal = 0;
            let discount = 0;
            let total = 0;
            let orderBy = "pos";
            $(document).ready(function () {
                
                $("#storeId").val("{{ $stores[0]->id }}");
    $("#storeId").change(function(){
    productInCart = [];
    renderElementCart(productInCart)
    })

    $('#elementPaylater').hide()
    $('#paymentCode').hide()

    $('#buttonPaylater').click(function () {
    $('#elementPaylater').toggle()
    })
    $('#paymentMethod').change(function () {
    if ($(this).val() == 4) {
    $('#elementPaylater').show()
    $('#paymentCode').hide()
    } else if ($(this).val() == 2 || $(this).val() == 3) {
    $('#elementPaylater').hide()
    $('#paymentCode').show()
    } else {
    $('#elementPaylater').hide()
    $('#paymentCode').hide()
    }
    })

    $("#discount").keyup(function () {
    if (subtotal - $(this).val() > -1) {
    discount = $(this).val()
    total = subtotal - discount
    $("#total").html("Rp " + total)
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
    // var query = [{
    // field: 'nik',
    // value: params.term
    // }]

    // return JSON.stringify(query);
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
    url: "{{ url('/api/product-by-sku') }}?sku=" + value + "&storeId=" +
    $("#storeId").val(),
    cache: "false",
    datatype: "html",
    success: function (response) {
    let toPush = {
    title: response.product.title,
    sku: response.product.sku,
    price: response.product.price,
    qty: 1,
    subtotal: response.product.price,
    stock: response.product.stock,
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
    text: "Produk tidak ditemukan atau stock sedang kosong",
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
    if (element.qty > 1) {
    element.qty -= 1;
    }
    } else if ($(this).hasClass('counter-plus')) {
    if (element.qty + 1 <= element.stock) { element.qty +=1; } } element.subtotal=element.price * element.qty return
        true; } return false; }); renderElementCart(productInCart); subtotal=countSubtotal(productInCart);
        total=subtotal - discount; $('#total').html("Rp " + total)
                })
            })

            $('#buttonCheckout').click(function () {
                if (productInCart.length < 1) {
                    swal({
                        title: " Gagal", text: "Belum ada produk yang ditambahkan" , type: "error" }); } let
        checkoutValue={ item: productInCart, discount: discount, storeId: $("#storeId").val(), orderBy: orderBy,
        paymentMethodId: $('#paymentMethod').val(), employeeOndutyId: "{{ auth()->user()->employee->id }}" } if
        ($('#paymentMethod').val()==4) { checkoutValue.paylater=$("#mySelect2").val() } else if
        ($('#paymentMethod').val()==2 || $('#paymentMethod').val()==3) { checkoutValue.paymentCode=paymentCode }
        $.ajax({ type: "POST" , processData: false, contentType: 'application/json' , cache: false,
        url: "{{ url('/api/order') }}" , data: JSON.stringify(checkoutValue), dataType: "json" ,
        enctype: 'multipart/form-data' , success: function (response) { if (response.status) { swal({ title: "Sukses" ,
        text: response.message, type: "success" }); } if (response.print==true) { let cash=$("#cash").val();
        window.open('{{ url("admin/print-receipt-order" ) }}/' + response.order.order_code + "?cash=" +cash, '_blank' );
        } setTimeout(function () { location.reload(); }, 1000) }, error: function (response) { console.log(response)
        swal({ title: "Gagal" , text: response.message, type: "error" }); } }); }); function renderElementCart(items) {
        $('#bodyCart').html(""); let elementHtml='' ; items.forEach(product=> {
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
                <small class="small text-danger">stock : ` + product.stock + `</small>
            </td>
            <td>` + product.subtotal + `</td>
            <td>
                <div class=" d-flex g-2">
                    <a class="btn text-danger bg-danger-transparent btn-icon py-1 delete-cart" data-bs-toggle="tooltip"
                        data-bs-original-title="Delete" id="dlt` + product.sku + `"><span
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

        for (let index = 0; index < item.length; index++) { sum +=item[index].subtotal; } $('#subtotalAll').html("Rp " + sum)
                return sum;
            }

        </script>
    </x-slot> --}}
</x-admin-layout>
