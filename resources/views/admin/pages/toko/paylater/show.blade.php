<x-admin-layout titlePage="{{ $titlePage }}">
    <div class="row">
        <div class="col-1">
            <a href="{{ route('admin.paylater.index') }}" class="btn btn-danger">back</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12 p-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        Detail Paylater
                    </div>
                </div>
                <div class="card-body py-2">
                    <div class="row pt-4">
                      <div class="col-12 col-md-6 mb-4">
                        <h5>Nama : {{ $employee->full_name }}</h5>
                        <h5>NIK : {{ $employee->nik }}</h5>
                        <h5>Department : {{ $employee->department->name ?? ""}}</h5>
                        <h5>Position : {{ $employee->position->name }}</h5>
                        <h5>status : {{ $employee->statusEmployee->name }}</h5>
                      </div>
                      <div class="col-12 col-md-6 mb-4">
                        <h5>{{ str('total Hutang Paylater')->title() }}</h5>
                        <h3 class="text-danger">{{ format_uang($totalNotPaid) }}</h3>
                        <h5>{{ str('total Paylater lunas')->title() }}</h5>
                        <h3 class="text-success">{{ format_uang($totalPaid) }}</h3>
                      </div>
                    </div>
                </div>
            </div>
            <div class="card cart">
                <div class="card-header">
                    <h3 class="card-title">Detail Pesanan</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-vcenter" id="datatable">
                            <thead class="table-primary">
                                <tr class="border-top">
                                    <th>No</th>
                                    <th>Kode Order</th>
                                    <th>Harga</th>
                                    <th>Tanggal</th>
                                    <th>status</th>
                                    <th>lunas</th>
                                    <th>action</th>
                                </tr>
                            </thead>
                            <tbody id="bodyCart">
                                @foreach ($paylaters as $i => $paylater)
                                  <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td>{{ $paylater->order_code }}</td>
                                    <td>{{ format_uang($paylater->amount) }}</td>
                                    <td>{{ $paylater->requestDate }}</td>
                                    <td><span class="btn btn-sm {{ $paylater->statusColor }}">{{ $paylater->status }}</span></td>
                                    <td>
                                      @if ($paylater->isPaid == 1)
                                        <span class="btn btn-sm btn-success">Lunas</span>
                                      @else
                                        <span class="btn btn-sm btn-danger">Belum Lunas</span>
                                      @endif
                                    </td>
                                    <td>
                                      <a href="{{ route('admin.order.show', $paylater->order_code) }}" class="btn btn-info">Lihat Detail</a>
                                    </td>
                                  </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-12 col-md-5 p-4">
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
        </div> --}}
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
    @slot('script')
    <script>
        $(document).ready(function () {
            $("#datatable").DataTable();
        })

    </script>
    @endslot
</x-admin-layout>
