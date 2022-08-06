<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="w-100 row">
                        <div class="col-md-4">
                            <div class="w-100  p-3">
                                <h4 class="h4 fw-bold">Formulir untuk Transfer Stock</h4>
                                <div class="form-group">
                                    <label for="originStore">Origin Store</label>
                                    <select name="originStore" class="form-control form-select select2"
                                        data-bs-placeholder="Masukan Sumber Toko" >
                                        @foreach ($stores as $store)
                                        <option value="{{ $store->id }}">{{ $store->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for=destinationnStore">Destination Store</label>
                                    <select name="destinationStore" class="form-control form-select select2"
                                        data-bs-placeholder="Masukan Tujuan Toko">
                                        @foreach ($stores as $store)
                                        <option value="{{ $store->id }}">{{ $store->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="w-100  p-3">
                                <h4 class="h4 fw-bold">Management stock Report</h4>
                                <form action="" method="post" class="mt-5">
                                    <div class="form-group">
                                        <label for="reportStock">Origin Store</label>
                                        <select name="reportStock" class="form-control form-select select2"
                                        data-bs-placeholder="Masukan Toko untuk direport">
                                            @foreach ($stores as $store)
                                            <option value="{{ $store->id }}">{{ $store->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit Report</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="w-100">
                      <div class="table-responsive">
                        <table class="table w-100">
                          <thead class="table-primary">
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Action</th>
                          </thead>
                          <tbody id="bodyTable">
                            <tr class="rowList">
                              <td>
                                <input type="text" class="product-list form-control" name="product[]" id="product" placeholder="Input Nama Produk">
                                <div class="card card-search-product" style="display: none;">
                                  <ul class="list-group list-group-flush">
                                    <li class="list-group-item product-show"></li>
                                  </ul>
                                </div>
                              </td>
                              <td><input type="number" class="quantity-list form-control" name="quantity[]" id="quantity" placeholder="Input Jumlah Produk"></td>
                              <td>
                                <span class="btn btn-danger deleteRows">&times;</span>
                                <span class="btn btn-primary addRows">&plus;</span>
                              </td>
                            </tr>
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

            $('.select2').select2({
                minimumResultsForSearch: '',
                width: '100%'
            });
            $("body").on("click", ".addRows",function(){
              let element = $(this).closest(".rowList").html();
              element = `<tr class="rowList">` + element + `</tr>`;
              $("#bodyTable").append(element);
            })
            $("body").on("click", ".deleteRows",function(){
              var numItems = $('.rowList').length;
              if(numItems > 1){
                $(this).closest(".rowList").remove();
              }
            })

            $("select[name='originStore']").change(function(){
              let value = $(this).val();
              originStore = value;
            })

            $(".product-list").keyup(function(){
              let value = $(this).val()
              if(value > 4){
                $(this).closest(".card-search-product").toggle();
              }
            })
        })

    </script>
    @endslot
</x-admin-layout>
