<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div>
                @if ($orderSupplier->status->name !== "reject")
                <div class="multi-step p-4 mb-4 d-flex justify-content-center position-relative">
                    <div class="w-75 border border-dark p-0 position-absolute top-50" style="z-index:-1;"></div>
                    <ul class="multi-step-bar nav align-items-center justify-content-between">
                        @foreach ($statuses as $status)
                        <li class="@if ($orderSupplier->status_id == $status->id)
                      active
                    @endif">{{ $status->name }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if ($orderSupplier->status->name == "reject")
                <div class="btn btn-danger-light mb-4 w-100">Tiket sudah dibatalkan</div>
                @endif
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Order Supplier</div>
                    <div class="card-options">
                        @if ($orderSupplier->status->name == "Create Ticket")
                        <a href="{{ route('admin.order-supplier.edit', $orderSupplier->id) }}"
                            class="btn btn-warning btn-sm">Edit Data Request</a>
                        <a href="{{ url('admin/toko/confirm-order-supplier/' . $orderSupplier->id) }}"
                            class="btn btn-info btn-sm ms-2">Konfirmasi Tiket Order Supplier</a>
                        @endif
                        @if ($orderSupplier->status->name == "Approved Ticket")
                        <button class="btn btn-info btn-sm ms-2">Print Surat Jalan</button>
                        <a href="{{ url('admin/toko/start-order-supplier/' . $orderSupplier->id) }}"
                            class="btn btn-info btn-sm ms-2">Mulai Order</a>
                        @endif
                        @if ($orderSupplier->status->name == "Ordering")
                        <button class="btn btn-info btn-sm ms-2">Print Surat Jalan</button>
                        <a href="{{ route('admin.order-supplier.receive', $orderSupplier->id) }}"
                            class="btn btn-info btn-sm ms-2">Konfirmasi Terima Produk</a>
                        @endif
                        @if ($orderSupplier->status->name !== "reject" && $orderSupplier->status->name !== "Receive")
                        <a href="{{ url('admin/toko/reject-order-supplierk/' . $orderSupplier->id) }}" class="btn btn-danger btn-sm delete-button ms-2" data-toggle="tooltip"
                            data-placement="top" title="Hapus Order Supplier">
                            Batalkan Pesanan<i class="fe fe-trash-2"></i>
                        </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="w-100 mb-4">
                        <div class="table-responsive">
                            <table class="table w-100 table-striped" id="datatable">
                                <tbody>
                                    <tr>
                                        <td>Order Supplier Kode</td>
                                        <td>:</td>
                                        <td>{{ $orderSupplier->order_supplier_code }}</td>
                                    </tr>
                                    <tr>
                                        <td>Data Supplier</td>
                                        <td>:</td>
                                        <td>
                                          <div>{{ $orderSupplier->Supplier->name}}</div>
                                          <div>{{ $orderSupplier->Supplier->contact_name}}</div>
                                          <div>{{ $orderSupplier->Supplier->contact_phone}}</div>
                                          <div>{{ $orderSupplier->Supplier->contact_address}}</div>
                                          <div>{{ $orderSupplier->Supplier->contact_link}}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Terima di Toko</td>
                                        <td>:</td>
                                        <td>{{ $orderSupplier->ToStore->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Request By</td>
                                        <td>:</td>
                                        <td>{{ $orderSupplier->requester->full_name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Request Time</td>
                                        <td>:</td>
                                        <td>{{ $orderSupplier->order_date}}</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>:</td>
                                        <td>
                                            <div class="btn btn-warning">{{ $orderSupplier->status->name }}</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="w-100 border">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="table-success fw-bold text-uppercase">
                                    <th>No</th>
                                    <th>Produk Name</th>
                                    <th>Jumlah pembelian</th>
                                    <th>Unit Pembelian</th>
                                </thead>
                                <tbody>
                                    @foreach ($orderSupplier->detailItem as $i => $item)
                                    <tr>
                                        <td>{{ $i+1 }}</td>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->request_qty }}</td>
                                        <td>{{ $item->request_unit }}</td>
                                    </tr>
                                    @endforeach
                                    <tr></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modalConfirmStock" tabindex="-1" aria-labelledby="modalConfirmStockLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content w-100" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalConfirmStockLabel">Konfirmasi Ketersediaan Stock</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                          @if ($orderSupplier->status->name == "Ordering")
                          <table class="table table-bordered">
                            <thead class="table-success fw-bold text-uppercase">
                              <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Jumlah Unit</th>
                                <th>Unit</th>
                                <th>Jumlah yang diterima</th>
                                <th>Jumlah per Unit</th>
                                <th>Harga per unit</th>
                                <th>subtotal</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($orderSupplier->detailItem as $j => $item)
                              <tr>
                                <td>{{ $j+1 }}</td>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->request_qty }}</td>
                                <td>{{ $item->request_unit }}</td>
                                <td>
                                  <input type="number" data-id="{{ $item->id }}" class="form-control receive-qty" placeholder="receive quantity">
                                </td>
                                <td>
                                  <input type="number" data-id="{{ $item->id }}" class="form-control quantity-per-unit" placeholder="quantity per unit">
                                </td>
                                <td>
                                  <input type="text" data-qty="{{ $item->request_qty }}" data-id="{{ $item->id }}" class="form-control format-uang price" placeholder="Harga">
                                </td>
                                <td>
                                  <input type="text" class="form-control format-uang subtotal" id="subtotal{{ $item->id }}" placeholder="subtotal">
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                          @endif
                          
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="submitReceive">Konfirmasi Ketersediaan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="style">
        <style>
            .multi-step-bar {
                width: 75%;
            }

            .multi-step-bar>li {
                padding: 4px 8px;
                background-color: rgb(223, 217, 241);
                color: rgb(27, 22, 56);
                border-radius: 4px;
            }

            .multi-step-bar>li.active {
                background-color: rgb(58, 160, 138);
                color: rgb(255, 255, 255);
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
          let data = [];
          
          $(".receive-qty").keyup(function(){
            let productId = $(this).data('id')
            let receive = parseInt($(this).val());
            const checker = data.find(element => {
                if (element.id === productId) {
                    element.receiveQty = receive
                    return true;
                }
                return false;
            });
            if(checker == undefined){
              toPush = {
                id: productId,
                quantityPerUnit: 0,
                receiveQty: receive,
                price: 0
              }
              data.push(toPush)
            }
          })
          $(".quantity-per-unit").keyup(function(){
            let productId = $(this).data('id')
            let qpuInput = parseInt($(this).val());
            const checker = data.find(element => {
                if (element.id === productId) {
                    element.quantityPerUnit = qpuInput
                    return true;
                }
                return false;
            });
            if(checker == undefined){
              toPush = {
                id: productId,
                quantityPerUnit: qpuInput,
                price: 0,
                receiveQty: 0
              }
              data.push(toPush)
            }
          })
          $(".price").keyup(function(){
            let productId = $(this).data('id')
            let qty = parseInt($(this).data('qty'))
            let price = $(this).val();
            price = parseInt(price.split(".").join("")) 

            subtotal = price*qty;
            $("#subtotal"+productId).val(formatRupiah(String(subtotal)))
            const checker = data.find(element => {
                if (element.id === productId) {
                    element.price = price
                    return true;
                }
                return false;
            });
            if(checker == undefined){
              toPush = {
                id: productId,
                quantityPerUnit: 0,
                price: price,
                receiveQty: 0
              }
              data.push(toPush)
            }
          })


          $("#submitReceive").click(function(){
            let orderSupplierId = "{{ $orderSupplier->id }}";
            let employeeId = "{{ auth()->user()->employee->id }}"
            let available = $(".input-available");
            $('*.form-control').each(function() {
                if ($(this).val() == null ||$(this).val() == "" ||$(this).val() == undefined) {
                    swal({
                        title: "Gagal",
                        text: "Masih ada data yg belum sesuai",
                        type: "error"
                    });
                    return false;
                }
            });

            let param = {
              orderSupplierId: orderSupplierId,
              employeeId: employeeId,
              data: data
            }
            console.log(param)

            $.ajax({
                type: "POST",
                processData: false,
                contentType: 'application/json',
                cache: false,
                url: "{{ url('/api/order-supplier-receive') }}",
                data: JSON.stringify(param),
                dataType: "json",
                enctype: 'multipart/form-data',
                success: function (response) {
                  swal({
                      title: "Sukses",
                      text: response.message,
                      type: "success"
                  });
                    
                    setTimeout(function () {
                        window.location.replace("{{ url('admin/toko/order-supplier') }}/{{ $orderSupplier->id }}");
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
