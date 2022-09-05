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
                            <thead class="table-primary">
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
                                    <td>{{ format_uang($detail->price)  }}</td>
                                    <td>{{ $detail->qty }}</td>
                                    <td>{{ format_uang($detail->subtotal) }}</td>
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
                                    <td class="text-end"><span
                                            class="fw-bold ms-auto">{{ $order->transaction->requester->full_name }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-start">Tanggal Pemohonan</td>
                                    <td class="text-end"><span
                                            class="fw-bold">{{ $order->transaction->transaction_date }}</span>
                                    </td>
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
                    </div>
                    </td>
                    </tr>

                    @endif
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
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <button id="rejectButton" class="btn btn-danger">Reject Order</button>
                    <button id="submitButton" class="btn btn-success ms-2">Checkout Order</button>
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
                $('#paymentCode').hide();

                $('#paymentMethod').change(function () {
                    console.log($(this).val())
                    if ($(this).val() == 'cash') {
                        $('#paymentCode').hide()
                        $('#cash').show()
                    } else {
                        $('#paymentCode').show()
                        $('#cash').hide()
                    }
                })

                $('#submitButton').click(function(){

                })
            })

        </script>
    </x-slot>
</x-admin-layout>
