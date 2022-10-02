<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Stock</div>
                    <div class="card-options">
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm">Print Dokumen Opname (PDF)</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="w-100">
                        <div class="table-responsive">
                            <table class="table w-100" id="datatable">
                                <thead class="table-primary">
                                    <th>
                                        <input type="checkbox" name="checkboxAll" id="checkboxAll">
                                    </th>
                                    <th>Produk</th>
                                    <th>Kode SKU</th>
                                    @foreach ($stores as $store)
                                    <th>{{ $store->name }}</th>
                                    @endforeach
                                </thead>
                                <tbody>
                                    @foreach ($stocks as $stock)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="checkboxAll" id="checkboxAll">
                                        </td>
                                        <td>{{ $stock->name }}</td>
                                        <td>{{ $stock->sku}}</td>
                                        <?php
                                        $qty = explode(",",$stock->qty);
                                          foreach ($qty as $key => $qt) {
                                            echo("<td>".$qt."</td>");
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
            <div class="card-title">History Stock Opname</div>
            <div class="card-options">
              <a href="{{ route('admin.opname.create') }}" class="btn btn-sm btn-primary">Buat Report Baru</a>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table" id="datatable2">
                <thead class="table-primary">
                  <th>No</th>
                  <th>Date</th>
                  <th>Staff</th>
                  <th>Jumlah Temuan</th>
                  <th>Status</th>
                  <th>Action</th>
                </thead>
                <tbody>
                  @foreach ($opnames as $k => $opname)
                    <tr>
                      <td>{{ $k+1 }}</td>
                      <td>{{ $opname->created_at }}</td>
                      <td>{{ $opname->employee->full_name }}</td>
                      <td>{{ count($opname->detail) }}</td>
                      <td>
                        @if ($opname->is_commit == false)
                          <span class="text-danger">Placed</span>
                          @else
                          <span class="text-success">Commit</span>
                        @endif
                      </td>
                      <td>
                        <a href="{{ route('admin.opname.show', $opname->id) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
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

            // $('.select2').select2({
            //     minimumResultsForSearch: '',
            //     width: '100%'
            // });
            // $("body").on("click", ".addRows", function () {
            //     let element = $(this).closest(".rowList").html();
            //     element = `<tr class="rowList">` + element + `</tr>`;
            //     $("#bodyTable").append(element);
            // })
            // $("body").on("click", ".deleteRows", function () {
            //     var numItems = $('.rowList').length;
            //     if (numItems > 1) {
            //         $(this).closest(".rowList").remove();
            //     }
            // })

            // $("select[name='originStore']").change(function () {
            //     let value = $(this).val();
            //     originStore = value;
            // })

            // $(".product-list").keyup(function () {
            //     let value = $(this).val()
            //     if (value > 4) {
            //         $(this).closest(".card-search-product").toggle();
            //     }
            // })
        })

    </script>
    @endslot
</x-admin-layout>
