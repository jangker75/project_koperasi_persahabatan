<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fw-bold">{{ str("list History Order")->title() }}</h3>
                    <div class="card-options">
                      <a href="{{ route('admin.request-order.index') }}" class="btn btn-primary">Refresh <i class="fa fa-refresh    "></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-small text-danger mb-2">*table ini hanya menampilkan 100 history order terbaru, untuk menampilkan lebih spesifik mohon gunakan fitur filter by tanggal</div>
                    <div class="d-flex w-50 mb-2">
                      <input type="text" name="daterange" class="form-control w-50 me-4" placeholder="Masukan tanggal">
                      <button class="btn btn-danger" id="resetDate">Reset tanggal</button>
                    </div>
                    <div class="w-100">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatable">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Order</th>
                                        <th>Total</th>
                                        <th>Tanggal</th>
                                        <th>Paylater</th>
                                        <th>Delivery</th>
                                        <th>Lunas</th>
                                        <th>Produk Terjual</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyTable">
                                    @foreach ($orders as $i => $order)
                                    <tr>
                                        <td>{{ $i+1 }}</td>
                                        <td>{{ $order->orderCode }}</td>
                                        <td>{{ format_uang($order->total) }}</td>
                                        <td>{{ $order->orderDate }}</td>
                                        <td>
                                          @if ($order->isPaylater == 1)
                                            <div class="btn btn-sm btn-info">Yes</div>
                                          @else
                                            <div class="btn btn-sm btn-warning">No</div>
                                          @endif
                                        </td>
                                        <td>
                                          @if ($order->isDelivery == 1)
                                            <div class="btn btn-sm btn-info">Yes</div>
                                          @else
                                            <div class="btn btn-sm btn-warning">No</div>
                                          @endif
                                        </td>
                                        <td>
                                          @if ($order->isPaid == 1)
                                            <div class="btn btn-sm btn-success">Lunas</div>
                                          @else
                                            <div class="btn btn-sm btn-danger">Belum Lunas</div>
                                          @endif
                                        </td>
                                        <td>
                                          {{ $order->totalQtyProduct }}
                                        </td>
                                        <td>
                                          <div class="btn btn-sm {{ $order->statusOrderColorButton}}">{{ $order->statusOrderName }}</div>
                                        </td>
                                        <td>
                                          <a href="{{ route('admin.order.show', $order->orderCode) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
                                          @if ($order->statusOrderName == "success")
                                            <a href="{{ route('admin.print-receipt', $order->orderCode) }}" target="_blank" data-code="{{ $order->orderCode}}" class="btn btn-sm btn-info reject-order print-order"><i class="fa fa-print"></i></a>                                           
                                          @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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
            let Data = [];
            let table = $("#datatable").DataTable();
            $('input[name="daterange"]').daterangepicker();
            $("#resetDate").click(function(){
              $('input[name="daterange"]').val("")
              let date = {
                start: null,
                end: null
              }

              $.ajax({
                  type: "POST",
                  processData: false,
                  contentType: 'application/json',
                  cache: false,
                  url: "{{ url('api/get-data-order') }}",
                  data: JSON.stringify(date),
                  dataType: "json",
                  enctype: 'multipart/form-data',
                  success: function (response) {
                    Data = response;
                    renderElement(Data);
                    $("#datatable").DataTable();
                  },
                  error: function (response) {
                    
                  }
              });
            })

            $('input[name="daterange"]').change(function(){
              let value = $(this).val();
              value = value.split('-')

              let date = {
                start: value[0].replace(" ", ""),
                end: value[1].replace(" ", "")
              }

              $.ajax({
                  type: "POST",
                  processData: false,
                  contentType: 'application/json',
                  cache: false,
                  url: "{{ url('api/get-data-order') }}",
                  data: JSON.stringify(date),
                  dataType: "json",
                  enctype: 'multipart/form-data',
                  success: function (response) {
                    Data = response;
                    renderElement(Data);
                    $("#datatable").DataTable();
                  },
                  error: function (response) {
                    
                  }
              });
            })

            function renderElement(arrOb){
              $("#bodyTable").html("")
              arrOb.forEach(function callback(element, index) {
                let isPaylater = "";
                let isDelivery = "";
                let isPaid = "";
                let print = `
                  <a href="{{ url('admin/pos/print-receipt') }}/`+element.orderCode+`" target="_blank" data-code="{{ `+element.orderCode+`}}" class="btn btn-sm btn-info reject-order print-order"><i class="fa fa-print"></i></a>
                `

                if(element.isPaylater == 1){
                  isPaylater = `<div class="btn btn-sm btn-info">Yes</div>`
                }else{
                  isPaylater = `<div class="btn btn-sm btn-warning">No</div>`
                }
                if(element.isDelivery == 1){
                  isDelivery = `<div class="btn btn-sm btn-info">Yes</div>`
                }else{
                  isDelivery = `<div class="btn btn-sm btn-warning">No</div>`
                }
                if(element.isPaid == 1){
                  isPaid = `<div class="btn btn-sm btn-success">Lunas</div>`
                }else{
                  isPaid = `<div class="btn btn-sm btn-danger">Belum Lunas</div>`
                }
                if(element.statusOrderName !== "success"){
                  print = ""
                }

                $("#bodyTable").append(`
                  <tr>
                    <td>`+ (index+1) +`</td>
                    <td>` + element.orderCode + `</td>
                    <td>` + formatRupiah(String(element.total), 'Rp')  + `</td>
                    <td>` + element.orderDate + `</td>
                    <td>
                      
                      ` + isPaylater + `
                    </td>
                    <td>
                      
                      ` + isDelivery + `
                    </td>
                    <td>
                      ` + isPaid + `
                    </td>
                    <td>
                      ` + element.totalQtyProduct + `
                    </td>
                    <td>
                      <div class="btn btn-sm {{ $order->statusOrderColorButton}}">{{ $order->statusOrderName }}</div>
                    </td>
                    <td>
                      <a href="{{ url('admin/pos/history-order') }}/`+element.orderCode+`" class="btn btn-sm btn-primary">Lihat Detail</a>
                      `+print+`
                    </td>
                </tr>
                `);
              });
            }
        })

    </script>
    @endslot
</x-admin-layout>
