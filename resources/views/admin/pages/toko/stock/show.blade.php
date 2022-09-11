<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div>
                <div class="multi-step p-4 mb-4 d-flex justify-content-center position-relative">
                    <div class="w-75 border border-dark p-0 position-absolute top-50" style="z-index:-1;"></div>
                    <ul class="multi-step-bar nav align-items-center justify-content-between">
                        @foreach ($statuses as $status)
                        <li class="@if ($transferStock->status_id == $status->id)
                      active
                    @endif">{{ $status->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Transfer Stock</div>
                    <div class="card-options">
                        @if ($transferStock->Status->name == "Create Ticket")
                        <a href="{{ route('admin.management-stock.edit', $transferStock->id) }}"
                            class="btn btn-warning btn-sm">Edit Data Request</a>
                        <a href="{{ url('admin/toko/confirm-ticket-transfer-stock/' . $transferStock->id) }}"
                            class="btn btn-info btn-sm ms-2">Konfirmasi Tiket Transfer Stock</a>
                        @else
                        @if ($transferStock->Status->name == "Approved Ticket")
                        <a href="{{ url('admin/toko/start-order-transfer-stock/' . $transferStock->id) }}"
                            class="btn btn-info btn-sm ms-2">Mulai Order</a>
                        @endif
                        @if ($transferStock->Status->name == "Ordering")
                        <button data-bs-toggle="modal" data-bs-target="#modalConfirmStock"
                            class="btn btn-info btn-sm ms-2">Konfirmasi Ketersediaan Produk</button>
                        @endif
                        {{-- <a href="javascript:void(0)" class="btn btn-info btn-sm ms-2">Konfirmasi Penerimaan Produk</a>
                        <a href="javascript:void(0)" class="btn btn-success btn-sm ms-2">Print Data Transfer Stock</a> --}}
                        @endif
                        <form action="{{ route('admin.management-stock.destroy', $transferStock->id) }}"
                            class="d-inline" method="post">
                            @csrf @method('delete')
                        </form>
                        <button type="submit" class="btn btn-danger btn-sm delete-button ms-2" data-toggle="tooltip"
                            data-placement="top" title="Hapus Transfer Stock">Batalkan Pesanan<i
                                class="fe fe-trash-2"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="w-100 mb-4">
                        <div class="table-responsive">
                            <table class="table w-100 table-striped" id="datatable">
                                <tbody>
                                    <tr>
                                        <td>Transfer Stock Kode</td>
                                        <td>:</td>
                                        <td>{{ $transferStock->transfer_stock_code }}</td>
                                    </tr>
                                    <tr>
                                        <td>Dari Toko</td>
                                        <td>:</td>
                                        <td>{{ $transferStock->FromStore->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tujuan Toko</td>
                                        <td>:</td>
                                        <td>{{ $transferStock->ToStore->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Request By</td>
                                        <td>:</td>
                                        <td>{{ $transferStock->Requester->getFullNameAttribute() }}</td>
                                    </tr>
                                    <tr>
                                        <td>Request Time</td>
                                        <td>:</td>
                                        <td>{{ $transferStock->req_date}}</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>:</td>
                                        <td>
                                            <div class="btn btn-warning">{{ $transferStock->Status->name }}</div>
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
                                    <th>Jumlah diminta</th>
                                    <th>Jumlah tersedia</th>
                                    <th>Jumlah diterima</th>
                                </thead>
                                <tbody>
                                    @foreach ($transferStock->detailItem as $i => $item)
                                    <tr>
                                        <td>{{ $i+1 }}</td>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->request_qty }}</td>
                                        <td>{{ $item->available_qty }}</td>
                                        <td>{{ $item->receive_qty }}</td>
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
                          <table class="table table-bordered">
                            <thead class="table-success fw-bold text-uppercase">
                              <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Stok Tersedia</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($availableStock as $j => $item)
                              <tr>
                                <td>{{ $j+1 }}</td>
                                <td>{{ $item->productName }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->stock }}</td>
                                <td>
                                  <input type="number" class="form-control input-available @if ($item->quantity > $item->stock)
                                    is-invalid
                                  @endif" placeholder="masukan jumlah yang akan dikirim"
                                    data-id="{{ $item->id }}" data-stock="{{ $item->stock }}" value="{{ $item->quantity }}">
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="submitAvailable">Konfirmasi Ketersediaan</button>
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
          $(".input-available").keyup(function(){
            let limit = parseInt($(this).data("stock"));
            let value = $(this).val();

            if (value > limit){
              if(!$(this).hasClass("is-invalid")){
                $(this).addClass("is-invalid");
              }
            }else{
              $(this).removeClass("is-invalid");
            }
          })

          $("#submitAvailable").click(function(){
            let transferStockId = "{{ $transferStock->id }}";
            let employeeId = "{{ auth()->user()->employee->id }}"
            let available = $(".input-available");
            $('*').each(function() {
                if ($(this).hasClass("is-invalid")) {
                    swal({
                        title: "Gagal",
                        text: "Masih ada data yg belum sesuai",
                        type: "error"
                    });
                    return false;
                }
            });

            let arrayAvailableValue = [];
            for(var i = 0; i < available.length; i++){
                let toPushAvailable = {
                  id: $(available[i]).data("id"),
                  value: parseInt($(available[i]).val()) 
                };
                arrayAvailableValue.push(toPushAvailable)
            }

            let param = {
              transferStockId: transferStockId,
              employeeId: employeeId,
              data: arrayAvailableValue
            }
            $.ajax({
              type: "POST",
              processData: false,
              contentType: 'application/json',
              cache: false,
              url: "{{ url('/api/transfer-stock-confirm') }}",
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
                      window.location.replace("{{ url('admin/toko/management-stock') }}/{{ $transferStock->id }}");
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
