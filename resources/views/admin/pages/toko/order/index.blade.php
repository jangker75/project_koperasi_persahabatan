<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fw-bold">{{ str("list History Order")->title() }}</h3>
                    <div class="card-options">
                        <a href="{{ route('admin.request-order.index') }}" class="btn btn-primary">Refresh <i
                                class="fa fa-refresh    "></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-small text-danger mb-2">*Table ini akan menampilkan 50 data terbaru, silahkan
                        gunakan filter page atau filter by tgl untuk menampilkan data berikutnya</div>
                    <div class="mb-2">Filter :</div>
                    <div class="row mb-4" id="filters">
                      <div class="col-auto">
                        <input type="text" class="form-control" id="orderCode"  placeholder="Kode order">
                      </div>
                      <div class="col-auto">
                        <select class="form-select" id="employeeId">
                            <option selected value="0">Pilih Staff</option>
                            @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                            @endforeach
                        </select>
                      </div>
                      <div class="col-auto">
                        <div class="input-group">
                            <input type="text" name="daterange" class="form-control"
                                placeholder="Masukan tanggal" autocomplete="off">
                            <button class="btn btn-danger btn-sm" id="resetDate">Reset tanggal</button>
                        </div>
                      </div>
                      <div class="col-auto">
                        <div class="d-flex align-items-center">
                            <span class="me-2">Page : </span>
                            <div class="handle-counter" id="handleCounter4">
                                <button type="button" class="counter-minus counter btn btn-white lh-2 shadow-none">
                                    <i class="fa fa-minus text-muted"></i>
                                </button>
                                <input type="text" value="1" class="page-number" id="pageNumber">
                                <button type="button" class="counter-plus counter btn btn-white lh-2 shadow-none">
                                    <i class="fa fa-plus text-muted"></i>
                                </button>
                            </div>
                        </div>
                      </div>
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
                                        <th>Nasabah</th>
                                        <th>Paylater</th>
                                        <th>Delivery</th>
                                        <th>Lunas</th>
                                        <th>Produk Terjual</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyTable">

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
            // let table = $("#datatable").DataTable();
            $('input[name="daterange"]').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD',
                    separator: " to "
                }
            });

            let params = [
              {
                key: "page",
                value: 1
              }
            ];

            refreshElement()

            // page
            $('.counter').click(function(){
              let valueNow = parseInt($("#pageNumber").val());
              if ($(this).hasClass('counter-plus')) {
                valueNow++;
              } else {
                $("#pageNumber").val()
                if (valueNow > 1) {
                  valueNow--;
                }
              }
              const checker = params.find(element => {
                  if (element.key == "page") {
                      element.value = valueNow
                      return element;
                  }

                  return false;
              });

              $("#pageNumber").val(valueNow)
              console.log(params)
              refreshElement()
            })

            // date
            $("#resetDate").click(function () {
                $('input[name="daterange"]').val("")

                // get index of object with id:37
                var removeIndex = params.map(function (item) {
                    return item.key;
                }).indexOf("date");

                // remove object
                params.splice(removeIndex, 1);

                console.log(params)
                refreshElement()
            })

            $('input[name="daterange"]').change(function () {
                let value = $(this).val();
                value = value.split('to')

                const checker = params.find(element => {
                    if (element.key == "date") {
                        element.value.startDate = value[0].replace(" ", ""),
                            element.value.endDate = value[1].replace(" ", "")
                        return element;
                    }

                    return false;
                });
                // console.log(checker)
                if (checker == undefined) {
                    let toPush = {
                        key: "date",
                        value: {
                            startDate: value[0].replace(" ", ""),
                            endDate: value[1].replace(" ", "")
                        }
                    }
                    params.push(toPush);
                }
                console.log(params)
                refreshElement()
                
            })

            // employee
            $("#employeeId").change(function(){
              let valueEmp = parseInt($(this).val()); 
              
              if(valueEmp == 0){
                // get index of object with id:37
                var removeIndex = params.map(function (item) {
                    return item.key;
                }).indexOf("employeeId");

                // remove object
                params.splice(removeIndex, 1);
              }else{
                const checker = params.find(element => {
                    if (element.key == "employeeId") {
                        element.value = valueEmp
                        return element;
                    }

                    return false;
                });
                // console.log(checker)
                if (checker == undefined) {
                    let toPush = {
                        key: "employeeId",
                        value: valueEmp
                    }
                    params.push(toPush);
                }
              }
              console.log(params)
              refreshElement()
            })

            // kodeOrder
            $("#orderCode").change(function(){
              let valueCode = $(this).val()
              if(valueCode == "" || valueCode == null){
                // get index of object with id:37
                var removeIndex = params.map(function (item) {
                    return item.key;
                }).indexOf("orderCode");

                // remove object
                params.splice(removeIndex, 1);
                
              }else{
                const checker = params.find(element => {
                    if (element.key == "orderCode") {
                        element.value = valueCode
                        return element;
                    }

                    return false;
                });
                if (checker == undefined) {
                    let toPush = {
                        key: "orderCode",
                        value: valueCode
                    }
                    params.push(toPush);
                }
              }

              console.log(params)
              refreshElement()
            })

            function renderElement(arrOb) {
                
                arrOb.forEach(function callback(element, index) {
                    let isPaylater = "";
                    let isDelivery = "";
                    let isPaid = "";
                    let requester = "";
                    let print = `<a href="{{ url('admin/pos/print-receipt') }}/` + element.orderCode +
                        `" target="_blank" data-code="{{ ` + element.orderCode + `}}" class="btn btn-sm btn-info reject-order print-order"><i class="fa fa-print"></i></a>`
                    if (element.isPaylater == 1) {
                        isPaylater = `<div class="btn btn-sm btn-info">Yes</div>`
                    } else {
                        isPaylater = `<div class="btn btn-sm btn-warning">No</div>`
                    }
                    if (element.isDelivery == 1) {
                        isDelivery = `<div class="btn btn-sm btn-info">Yes</div>`
                    } else {
                        isDelivery = `<div class="btn btn-sm btn-warning">No</div>`
                    }
                    if (element.isPaid == 1) {
                        isPaid = `<div class="btn btn-sm btn-success">Lunas</div>`
                    } else {
                        isPaid = `<div class="btn btn-sm btn-danger">Belum Lunas</div>`
                    }
                    if (element.requesterName != null) {
                        requester = `<div>` + element.requesterName + `</div>`
                    } else {
                        requester = `<div>--</div>`
                    }

                    if (element.statusOrderName !== "success") {
                        print = ""
                    }

                    $("#bodyTable").append(`
                      <tr>
                        <td>` + (index + 1) + `</td>
                        <td>` + element.orderCode + `</td>
                        <td>` + formatRupiah(String(element.total), 'Rp') + `</td>
                        <td>` + element.orderDate + `</td>
                        <td>` + requester + `</td>
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
                          <div class="btn btn-sm `+element.statusOrderColorButton+`">`+element.statusOrderName+`</div>
                        </td>
                        <td>
                          <a href="{{ url('admin/pos/history-order') }}/` + element.orderCode + `" class="btn btn-sm btn-primary">Lihat Detail</a>
                          ` + print + `
                        </td>
                      </tr>
                    `);
                });

                $("#datatable").DataTable();
            }

            function refreshElement() {
                $("#bodyTable").html("")
                let value = {
                    params: params
                }
                $.ajax({
                    type: "POST",
                    processData: false,
                    contentType: 'application/json',
                    cache: false,
                    url: "{{ url('api/get-data-order') }}",
                    data: JSON.stringify(value),
                    dataType: "json",
                    enctype: 'multipart/form-data',
                    success: function (response) {
                        Data = response;
                        
                    },
                    error: function (response) {

                    },
                    complete: function(data){
                      renderElement(Data);
                    }
                });

                // $("#datatable").DataTable();
            }
        })

    </script>
    @endslot
</x-admin-layout>
