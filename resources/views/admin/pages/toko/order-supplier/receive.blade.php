<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Order Supplier</div>
                    <div class="card-options">

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
                                    <tr>
                                      <td>Metode Bayar</td>
                                      <td>:</td>
                                      <td>
                                        <select class="form-select" name="is_paid" id="isPaid">
                                          <option value="true">Bayar Lunas</option>
                                          <option value="false">Sistem Setor</option>
                                        </select>
                                      </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Konfirmasi Penerimaan Order Supplier</div>
                </div>
                <div class="card-body">
                    @foreach ($detail as $item)
                    <div class="row row-sm border">
                        <div class="col-2">
                            <div class="mb-2">
                                Produk :
                            </div>
                            <span class="fw-bold h5">{{ $item->title }}</span>
                            <div class="mt-4 mb-2">
                                Permintaan :
                            </div>
                            <div class="h5 fw-bold">{{ $item->quantity . " " . $item->unit }}</div>
                        </div>

                        <div class="col-4">
                            <div class="mb-2">
                                Terima :
                            </div>
                            <div class="row row-sm mb-2">
                                <div class="col-6 mb-2">
                                    <label for="" class="fw-bold">Unit Terima</label>
                                    <input type="text" data-id="{{ $item->id }}" placeholder="Unit Terima" class="form-control unit-receive" value="{{ $item->unit }}">
                                </div>
                                <div class="col-6 mb-2">
                                    <label for="" class="fw-bold">Jumlah diterima</label>
                                    <input type="number" data-id="{{ $item->id }}" placeholder="Jumlah unit yang diterima" class="form-control quantity-receive" value="{{ $item->quantity }}">
                                </div>
                                <div class="col-6 mb-2">
                                    <label for="" class="fw-bold">Jumlah per Unit</label>
                                    <input type="number" data-id="{{ $item->id }}" placeholder="Jumlah isi dalam unit" class="form-control quantity-per-unit">
                                </div>
                                <div class="col-6 mb-2">
                                    <label for="" class="fw-bold">Harga per Unit</label>
                                    <input type="text" data-id="{{ $item->id }}" placeholder="Harga per Unit" class="form-control format-uang price-per-unit">
                                </div>
                                <div class="col-12 mb-2">
                                    Total Harga : <span class="subtotal fw-bold text-primary" data-id="{{ $item->id }}">Rp 0</span>
                                </div>
                                <div class="col-12 mb-2">
                                    Total Item Keseluruhan : <span class="quantity-all fw-bold text-primary" data-id="{{ $item->id }}">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-2">
                                Konfigurasi Harga :
                            </div>
                            <div class="row row-sm p-2">
                                <div class="col-6">
                                    <div class="mb-2 fw-bold">Harga saat ini : </div>
                                    <div class="border">Harga Beli : {{ format_uang($item->priceCost) }}</div>
                                    <div class="border">Harga Jual : {{ format_uang($item->priceRevenue) }}</div>
                                    <div class="border">Margin : {{ $item->priceMargin }} %</div>
                                    <div class="border">Keuntungan : {{ format_uang($item->priceProfit) }}</div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-2 fw-bold">Harga Setelah Order Supplier : </div>
                                    <div class="border">Harga Beli : 
                                      <span class="text-primary new-cost" data-id="{{ $item->id }}">{{ format_uang($item->priceCost) }}</span> 
                                    </div>
                                    <div class="border">
                                        <div class="d-flex justify-content-between mb-2">
                                          <span>
                                            Harga Jual :
                                          </span>
                                          <div class="form-check">
                                              <input data-id="{{ $item->id }}" class="form-check-input is-same-price" type="checkbox" value=""
                                                  id="checkbox">
                                              <label class="form-check-label" for="checkbox">
                                                  Tidak Berubah
                                              </label>
                                          </div>
                                        </div>
                                        <input type="text" class="form-control new-revenue format-uang"
                                            placeholder="Masukan Harga Jual Baru" data-id="{{ $item->id }}">
                                        <span class="text-primary price-before" data-id="{{ $item->id }}">{{ format_uang($item->priceRevenue) }}</span>
                                    </div>
                                    <div class="border">Margin : 
                                      <span class="text-primary new-margin" data-id="{{ $item->id }}">0</span>%
                                      <span class="text-small text-danger">(minimal margin adalah {{ $margin }}%)</span>
                                    </div>
                                    <div class="border" data-id="{{ $item->id }}">Keuntungan : 
                                      <span class="text-primary new-profit" data-id="{{ $item->id }}">Rp 0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <button id="submit" class="btn btn-primary mb-4 w-100">Submit</button>
        </div>
    </div>

    <x-slot name="style">
        <style>
        </style>
    </x-slot>

    <x-slot name="scriptVendor">
        <script src="{{ asset('/assets/plugins/fileuploads/js/fileupload.js') }}"></script>
        <script src="{{ asset('../assets/plugins/select2/select2.full.min.js') }}"></script>
    </x-slot>

    @slot('script')
    <script>
        $(document).ready(function () {
          $(".price-before").hide()
          let isPaid = true;
          let orderSupplierId = "{{ $orderSupplier->id }}";
          let detail = "{{ $detailStringify }}";
          detail = JSON.parse(detail.replace(/&quot;/g,'"'));

          detail.forEach(function callback(element, index) {
            element.receiveUnit = element.unit;
            element.receiveQty = element.quantity;
            element.quantityPerUnit = 0;
            element.pricePerUnit = 0;
            element.subtotal = 0;
            element.quantityAll = 0;
            element.isSamePrice = 0;
            element.newCost = element.priceCost;
            element.newRevenue = 0;
            element.newMargin = 0;
            element.newProfit = 0;
          });

          $(".is-same-price").click(function(){
            let id = $(this).data("id");
            let value = $(this).is(':checked')
            changeAllValue(id, detail, 'isSamePrice', value)
            if(value){
              $(".new-revenue[data-id="+id+"]").val("")
              $(".new-revenue[data-id="+id+"]").hide()
              $(".price-before[data-id="+id+"]").show()
            }else{
              $(".new-revenue[data-id="+id+"]").show()
              $(".price-before[data-id="+id+"]").hide()

            }
          })

          $(".unit-receive").change(function(){
            let id = $(this).data("id")
            let value = $(this).val();
            changeAllValue(id, detail, 'receiveUnit', value)
          })

          $(".quantity-receive").change(function(){
            let id = $(this).data("id")
            let value = parseInt($(this).val());

            if(value > 0){
              changeAllValue(id, detail, 'receiveQty', value)
            }
          })

          $(".quantity-per-unit").change(function(){
            let id = $(this).data("id")
            let value = parseInt($(this).val());
            if(value > 0){
              changeAllValue(id, detail, 'quantityPerUnit', value)
            }
          })

          $(".price-per-unit").change(function(){
            let id = $(this).data("id")
            let value = $(this).val();
            value = parseInt(value.replace(".", ""));
            if(value > 0){
              changeAllValue(id, detail, 'pricePerUnit', value)
            }
          })

          $(".new-revenue").change(function(){
            let id = $(this).data("id")
            let value = $(this).val();
            value = parseInt(value.replace(".", ""));
            if(value > 0){
              changeAllValue(id, detail, 'newRevenue', value)
            }
          })

          function changeAllValue(id, data, key, value){
            const checker = data.find(element => {
                if (element.id == id) {
                  switch (key) {
                    case 'receiveUnit':
                      element.receiveUnit = value;
                      break;
                    case 'receiveQty':
                      element.receiveQty = value;
                      break;
                    case 'pricePerUnit':
                      element.pricePerUnit = value;
                      break;
                    case 'quantityPerUnit':
                      element.quantityPerUnit = value;
                      break;
                    case 'newRevenue':
                      element.newRevenue = value;
                      break;
                    case 'isSamePrice':
                      element.isSamePrice = value;
                      if(value == true){
                        element.newRevenue = element.priceRevenue;
                      }else{
                        element.newRevenue = 0;
                      }
                      break;
                  
                    default:
                      break;
                  }
                  element.subtotal = element.receiveQty * element.pricePerUnit;
                  element.quantityAll = element.receiveQty * element.quantityPerUnit;
                  element.newCost = Math.round((element.subtotal/element.quantityAll)*10)/10;
                  element.newProfit = element.newRevenue - element.newCost;
                  element.newMargin = Math.round((element.newProfit*100/element.newRevenue)*10)/10;
                  return true;
                }
                return false;
            });
            console.log(checker)
            if(checker !== undefined){
              $(".subtotal[data-id=" + checker.id + "]").html(formatRupiah(String(checker.subtotal), 'Rp'))
              $(".quantity-all[data-id=" + checker.id + "]").html(checker.quantityAll);
              $(".new-cost[data-id=" + checker.id + "]").html(formatRupiah(String(checker.newCost), 'Rp'));
              $(".new-margin[data-id=" + checker.id + "]").html(checker.newMargin);
              $(".new-profit[data-id=" + checker.id + "]").html(formatRupiah(String(checker.newProfit), 'Rp'));
            }
          }

          $('#submit').click(function(){
            
            let params = {
              isPaid: isPaid,
              orderSupplierId: orderSupplierId,
              data: detail
            }

            console.log(params);
            $.ajax({
                  type: "POST",
                  processData: false,
                  contentType: 'application/json',
                  cache: false,
                  url: "{{ url('api/order-supplier-receive') }}",
                  data: JSON.stringify(params),
                  dataType: "json",
                  enctype: 'multipart/form-data',
                  success: function (response) {
                    swal({
                        title: "Sukses",
                        text: response.message,
                        type: "success"
                    });
                      
                      setTimeout(function () {
                          window.location.replace("{{ url('admin/toko/order-supplier') }}");
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
    @endslot
</x-admin-layout>
