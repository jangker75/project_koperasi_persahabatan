<x-admin-layout titlePage="{{ $titlePage }}">
    <div class="row">
        <div class="col-1">
            <a href="{{ route('admin.request-order.index') }}" class="btn btn-danger">back</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-7 p-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        Detail Order
                    </div>
                </div>
                <div class="card-body py-2">
                    <div class="table-responsive">
                        <table class="table table-borderless text-nowrap mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-start">Nama Pemohon</td>
                                    <td class="text-end">
                                      @if ($order->transaction->requester !== null)
                                      <span class="fw-bold ms-auto">{{ $order->transaction->requester->full_name }}</span>
                                      @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-start">Tanggal Pemohonan</td>
                                    @if ($order->transaction->is_paylater == true)
                                      
                                    <td class="text-end"><span
                                      class="fw-bold">{{ $order->transaction->transaction_date }}</span>
                                    </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td class="text-start">Paylater</td>
                                    <td class="text-end">
                                        @if ($order->transaction->is_paylater == 1)
                                        <div class="btn btn-sm btn-info">Yes</div>
                                        @else
                                        <div class="btn btn-sm btn-warning">No</div>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-start">Delivery</td>
                                    <td class="text-end">
                                        @if ($order->transaction->is_delivery == 1)
                                        <div class="btn btn-sm btn-info">Yes</div>
                                        @else
                                        <div class="btn btn-sm btn-warning">No</div>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-start">Pelunasan</td>
                                    <td class="text-end">
                                        @if ($order->transaction->is_paid == 1)
                                        <div class="btn btn-sm btn-success">Lunas</div>
                                        @else
                                        <div class="btn btn-sm btn-danger">Belum Lunas</div>
                                        @endif
                                    </td>
                                </tr>
                                @if ($order->transaction->is_paylater == 1)
                                <tr>
                                    <td class="text-start">Status Paylater</td>
                                    <td class="text-end">
                                        <div class="btn {{ $order->transaction->statusPaylater->color_button }}">
                                            {{ $order->transaction->statusPaylater->name }}
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @if ($order->transaction->is_delivery == 1)
                                <tr>
                                    <td class="text-start">Catatan Antar</td>
                                    <td class="text-end">
                                        <textarea name="" id="" class="form-control" rows="3"
                                            readonly>{{ $order->note }}</textarea>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card cart">
                <div class="card-header">
                    <h3 class="card-title">Detail Pesanan</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-vcenter">
                            <thead class="table-primary">
                                <tr class="border-top">
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="bodyCart">
                                @foreach ($order->detail as $detail)
                                <tr>
                                    <td>{{ $detail->product_name }}</td>
                                    <td>{{ format_uang($detail->price)  }}</td>
                                    <td>{{ $detail->qty }}</td>
                                    <td>{{ format_uang($detail->subtotal) }}</td>
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
                                @if ($order->transaction->is_delivery == 1)
                                <tr>
                                    <td class="text-start">Ongkos Kirim</td>
                                    <td class="text-end">{{ format_uang($order->transaction->delivery_fee) }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="text-start">Tax</td>
                                    <td class="text-end">{{ format_uang($order->transaction->delivery_fee) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-start">Additional Discount</td>
                                    <td class="text-end">
                                        {{ format_uang($order->discount) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-start fs-18">Total Bill</td>
                                    <td class="text-end"><span class="ms-2 fw-bold fs-23"
                                            id="total">{{ format_uang($order->total) }}</span></td>
                                </tr>
                            </tbody>
                        </table>
                        @if ($order->transaction->is_paylater == 0 || $order->transaction->is_paylater == null)
                        @if($order->transaction->statusTransaction->name == "waiting")
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="form-group">
                                    <label for="">Pilih Metode Pembayaran</label><br>
                                    <select class="form-select w-100" aria-label="Default select example"
                                        name="payment_method" id="paymentMethod" value="1">
                                        @foreach ($paymentMethod as $payment)
                                        <option value="{{ $payment->name }}">{{ $payment->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </li>
                            <li class="list-group-item" id="cash">
                                <div class="form-group">
                                    <label for="">Masukan Jumlah Uang Cash</label><br>
                                    <input type="text" name="cash" id="cashInput" class="form-control format-uang"
                                        placeholder="Rp 50.000">
                                </div>
                            </li>
                            <li class="list-group-item" id="paymentCode">
                                <div class="form-group">
                                    <label for="">Masukan Kode Pembayaran</label><br>
                                    <input type="text" name="payment_code" id="paymentCodeInput" class="form-control"
                                        placeholder="81723......">
                                </div>
                            </li>
                        </ul>
                        @endif
                        @endif
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        @if ($order->transaction->is_paid !== 1)
                        <a href="{{ route('admin.order.paid', $order->order_code) }}"
                            class="btn btn-info ms-2">Bayar Order</a>
                        @endif
                        @if ($order->status->name == "success")
                        <a href="{{ route('admin.print-receipt', $order->order_code) }}" target="_blank"
                            class="btn btn-info ms-2">Print Order <i class="fa fa-print"></i></a>
                        @elseif ($order->status->name == "failed")
                        <button class="btn btn-danger ms-2">Request ini dibatalkan</button>
                        @else
                        <button id="rejectButton" class="btn btn-danger">Reject Order</button>
                        <button id="submitButton" class="btn btn-success ms-2">Checkout Order</button>
                        @endif
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

    <x-slot name="script">
        <script>
            $(document).ready(function () {
                let discount = 0;
                let paymentCode = "";
                let cash = "0";
                let subtotal = parseInt('{{ $order->subtotal }}');
                let total = parseInt('{{ $order->total }}');
                let orderCode = '{{ $order->order_code }}';
                let employeeOndutyId = '{{ Auth::user()->employee->id }}'

                $('#paymentCode').hide();
                $('#paymentMethod').val("{{ $paymentMethod[0]->name }}")

                $('#paymentMethod').change(function () {

                    if ($(this).val() == 'cash') {
                        $('#paymentCode').hide()
                        $('#cash').show()
                    } else {
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
                })

                $('#rejectButton').click(function () {
                    let dataReject = {
                        orderCode: orderCode,
                        employeeOndutyId: employeeOndutyId
                    }

                    $.ajax({
                        type: "POST",
                        processData: false,
                        contentType: 'application/json',
                        cache: false,
                        url: "{{ url('/api/reject-order') }}",
                        data: JSON.stringify(dataReject),
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
                            if (response.print == true) {
                                // let cash = $("#cash").val();
                                window.open('{{ url("admin/pos/print-receipt" ) }}/' +
                                    response.order.order_code, '_blank');
                            }
                            setTimeout(function () {
                                location.reload();
                            }, 1000)
                        },
                        error: function (response) {
                            console.log(response)
                            swal({
                                title: "Gagal",
                                text: response.responseJSON.message,
                                type: "error"
                            });
                        }
                    });
                })

                $('#submitButton').click(function () {
                    let dataValue = {
                        orderCode: orderCode,
                        employeeOndutyId: employeeOndutyId,
                        paymentMethod: $('#paymentMethod').val(),
                        discount: discount,
                        cash: cash
                    }

                    if ($('#paymentMethod').val() == 'cash') {
                        setCash = parseInt(cash.replace(".", ""));
                        if (setCash < total) {
                            swal({
                                title: "Gagal",
                                text: "Cash harus lebih dari total harga",
                                type: "error"
                            });
                            return false;
                        }
                        dataValue.cash = setCash

                    } else {
                        dataValue.paymentCode = paymentCode
                    }

                    $.ajax({
                        type: "POST",
                        processData: false,
                        contentType: 'application/json',
                        cache: false,
                        url: "{{ url('/api/checkout-order') }}",
                        data: JSON.stringify(dataValue),
                        dataType: "json",
                        enctype: 'multipart/form-data',
                        success: function (response) {
                            console.log(response)
                            if (response.status) {
                                swal({
                                    title: "Sukses",
                                    text: response.message,
                                    type: "success"
                                });
                            }
                            if (response.print == true) {
                                let cash = $("#cash").val();
                                // window.open('{{ url("admin/print-receipt-order" ) }}/' + response.order.order_code + "?cash="+cash, '_blank');
                            }
                            setTimeout(function () {
                                location.reload();
                            }, 1000)
                        },
                        error: function (response) {
                            console.log(response)
                            swal({
                                title: "Gagal",
                                text: response.responseJSON.message,
                                type: "error"
                            });
                        }
                    });
                })
            })

        </script>
    </x-slot>
</x-admin-layout>
