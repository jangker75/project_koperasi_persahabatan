<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Stock</div>
                    <div class="card-options">
                        <a class="modal-effect btn btn-primary-light btn-sm d-grid" data-bs-effect="effect-slide-in-bottom"
                            data-bs-toggle="modal" href="#modaldemo8">Print Dokumen Opname (PDF)</a>

                        <div class="modal fade" id="modaldemo8" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered text-center" role="document">
                                <div class="modal-content modal-content-demo">
                                    <div class="modal-header">
                                        <h6 class="modal-title">Konfigurasi Print Dokumen Opname</h6>
                                        <button aria-label="Close"
                                            class="btn-close" data-bs-dismiss="modal"><span
                                                aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-start">
                                        <h6>Filter: </h6>
                                        <div class="row">
                                          <div class="col-6 mb-2">
                                            <div class="form-group select2-sm">
                                                <label class="form-label">Pilih Toko</label>
                                                <select name="store_id" id="printStoreId" class="form-control form-select form-select-sm select2 select2-hidden-accessible" data-bs-placeholder="Select Store" tabindex="-1" aria-hidden="true">
                                                  @foreach ($stores as $store)
                                                  <option value="{{ $store->id }}">{{ $store->name }}</option>
                                                  @endforeach
                                                </select>
                                            </div>
                                          </div>
                                          <div class="col-6 mb-2">
                                            <div class="form-group select2-sm">
                                                <label class="form-label">Pilih Mode Print</label>
                                                <select name="mode" id="printMode" class="form-control form-select form-select-sm select2 select2-hidden-accessible" data-bs-placeholder="Select Store" tabindex="-1" aria-hidden="true">
                                                  <option value="orderToday">Berdasarkan Order Hari ini</option>
                                                  <option value="category">Berdasarkan Kategori Produk</option>
                                                  <option value="allProduct">Semua Produk</option>
                                                </select>
                                            </div>
                                          </div>
                                          <div class="col-12 mb-2" id="colCategory">
                                            <div class="form-group select2-sm">
                                                <label class="form-label">Pilih Kategori</label>
                                                <select name="category_id" id="printCategoryId" class="form-control form-select form-select-sm select2 select2-hidden-accessible" data-bs-placeholder="Select Store" tabindex="-1" aria-hidden="true">
                                                  @foreach ($categories as $category)
                                                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                  @endforeach
                                                </select>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" id="submitPrint">Print</button> <button
                                            class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="w-100">
                        <div class="table-responsive">
                            <table class="table w-100" id="datatable2">
                                <thead class="table-primary">
                                    <th>Produk</th>
                                    <th>Kode SKU</th>
                                    @foreach ($stores as $store)
                                    <th>{{ $store->name }}</th>
                                    @endforeach
                                </thead>
                                <tbody>
                                    @foreach ($stocks as $stock)
                                    <tr>
                                        <td>{{ $stock->name }}</td>
                                        <td>{{ $stock->sku}}</td>
                                        <?php
                                          $qtyResult = json_decode($stock->qtyResult, true);
                                          // dd($qtyResult);
                                          foreach ($stores as $store) {
                                            $qty = array_filter($qtyResult, function($result) use ($store){
                                              return $result['store_id'] == $store->id;
                                            });
                                            
                                            if(count($qty) > 0){
                                              $qty = array_values($qty)[0];
                                              echo("<td>".$qty['quantity']."</td>");
                                            }else{
                                              echo("<td>0</td>");
                                            }
                                          }
                                        ?>
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
    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Transfer Stock</div>
                    <div class="card-options">
                        <a href="{{ route('admin.management-stock.create') }}" class="btn btn-primary btn-sm">Buat Transfer Stock +</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="w-100">
                        <div class="table-responsive">
                            <table class="table w-100 " id="datatable2">
                                <thead class="table-success fw-bold text-uppercase">
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Sumber Toko</th>
                                    <th>Tujuan Toko</th>
                                    <th>Tanggal</th>
                                    <th>Requester</th>
                                    <th>Sender</th>
                                    <th>Status Transfer</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($transfer_stocks as $i => $trStock)
                                    <tr>
                                        <td>{{ $i+1 }}</td>
                                        <td>{{ $trStock->transfer_stock_code }}</td>
                                        <td>{{ $trStock->fromStore->name}}</td>
                                        <td>{{ $trStock->toStore->name}}</td>
                                        <td>{{ $trStock->req_date}}</td>
                                        <td>{{ $trStock->requester->getFullNameAttribute() }}</td>
                                        <td>{{ isset($trStock->sender) ? $trStock->sender->getFullNameAttribute() : "Belum ada";}}</td>
                                        <td><span class="btn btn-primary-light btn-sm">{{ $trStock->status->name }}</span></td>
                                        <td>
                                            <a href="{{ route('admin.management-stock.show', $trStock->id) }}" class="btn btn-success btn-sm me-1" data-toggle="tooltip"
                                                data-placement="top" title="Edit Data Transfer Stock">Detail Transfer Stock <i
                                                    class="fe fe-edit"></i></a>
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
        <script src="{{ asset('../assets/plugins/select2/select2.full.min.js') }}"></script>
    </x-slot>

    @slot('script')
    <script>
        $(document).ready(function () {
            let originStore;
            let listProduk;

            $("#datatable").DataTable();
            $("#datatable2").DataTable();

            $('.select2').select2({
                minimumResultsForSearch: '',
                width: '100%'
            });
            $("body").on("click", ".addRows", function () {
                let element = $(this).closest(".rowList").html();
                element = `<tr class="rowList">` + element + `</tr>`;
                $("#bodyTable").append(element);
            })
            $("body").on("click", ".deleteRows", function () {
                var numItems = $('.rowList').length;
                if (numItems > 1) {
                    $(this).closest(".rowList").remove();
                }
            })

            $("select[name='originStore']").change(function () {
                let value = $(this).val();
                originStore = value;
            })

            $(".product-list").keyup(function () {
                let value = $(this).val()
                if (value > 4) {
                    $(this).closest(".card-search-product").toggle();
                }
            })

            $("#colCategory").hide();
            let printStoreId = "{{ $stores[0]->id }}";
            let printMode = "orderToday";
            let printCategoryId = "{{ $categories[0]->id }}";

            $("#printStoreId").change(function(){
              printStoreId = $(this).val()
              console.log(printStoreId)
            })

            $("#printCategoryId").change(function(){
              printCategoryId = $(this).val()
              console.log(printCategoryId)
            })

            $("#printMode").change(function(){
              printMode = $(this).val()
              console.log(printMode)
              if(printMode == "category"){
                $("#colCategory").show();
              }else{
                $("#colCategory").hide();
              }
            })

            $("#submitPrint").click(function(){
              let url = "{{ url('admin/toko/print-form-opname') }}?storeId="+printStoreId+"&mode="+printMode;
              if(printMode == 'category'){
                url = url + "&categoryId=" + printCategoryId;
              }
              window.open(url, "", "width=800,height=400");
            })
        })

    </script>
    @endslot
</x-admin-layout>
