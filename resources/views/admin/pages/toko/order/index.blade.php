<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fw-bold">{{ str("list History Order")->title() }}</h3>
                    <div class="card-options">
                        <a href="{{ route('admin.order.index') }}" class="btn btn-primary">Refresh <i
                                class="fa fa-refresh    "></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="h5">Total Transaksi</div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-3">
                            filter :
                            <div class="input-group">
                                <input type="text" name="daterange" class="form-control" placeholder="Masukan tanggal"
                                    autocomplete="off">
                                <button class="btn btn-danger btn-sm" id="resetDate">Reset tanggal</button>
                            </div>
                        </div>
                        <div class="col-3"></div>
                        <div class="col-6">
                          <div class="fw-bold text-danger mb-2">Total Paylater : <span id="totalPaylater"></span></div>
                          <div class="fw-bold text-success m-0">Total Pendapatan : <span id="totalPrice"></span></div>
                        </div>
                    </div>
                    <input type="hidden" name="page" value="1">
                    <div class="w-100">
                        <span>*secara default akan menampilkan data order hari ini</span>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatable">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th data-id="date">Tanggal</th>
                                        <th data-id="orderCode">Kode Order</th>
                                        <th data-id="total">Total</th>
                                        <th data-id="nasabah">Nasabah</th>
                                        <th data-id="paylater">Paylater</th>
                                        <th data-id="delivery">Delivery</th>
                                        <th data-id="lunas">Lunas</th>
                                        <th>Produk Terjual</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyTable">

                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div id="pagination"></div>
                            <div id="information"></div>
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
    @include('admin.pages.toko.order.index-script-datatable')
    <script>
        $(document).ready(function(){
          $('input[name="daterange"]').daterangepicker({
              locale: {
                  format: 'YYYY-MM-DD',
                  separator: " to "
              }
          });

          getData();
      
          $('input[name="daterange"]').change(function () {
              $("[name=page]").val("1")
              getData();
          })
      
          $("#resetDate").click(function () {
              $('input[name="daterange"]').val("")
          })
      
          $("body").on("click", "#buttonSearch", function(){
            $("[name=page]").val("1")
            getData();
          })

          $("body").on("click", ".btn-page", function(){
              let link = $(this).data("link");
              console.log(link)
              if(link == "« Previous"){
                link = parseInt($("[name=page]").val()) - 1;
              }else if(link == "Next »"){
                link = parseInt($("[name=page]").val()) + 1;
              }
              $("[name=page]").val(link)
              getData();
          })
        })
    </script>
    @endslot
</x-admin-layout>
