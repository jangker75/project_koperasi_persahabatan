<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Stock</div>
                    <div class="card-options">
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm">Print Data Stock (PDF)</a>
                        <a href="javascript:void(0)" class="btn btn-success btn-sm ms-2">Print Data Stock (Excel)</a>
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
                                        $qty = json_decode($stock->qty,true);
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
                                        <td><span class="badge bg-danger p-2">{{ $trStock->status->name }}</span></td>
                                        <td>
                                            
                                            <a href="{{ route('admin.management-stock.show', $trStock->id) }}" class="btn btn-success btn-sm me-1" data-toggle="tooltip"
                                                data-placement="top" title="Edit Data Transfer Stock">Detail Transfer Stock <i
                                                    class="fe fe-edit"></i></a>
                                            <form action="{{ route('admin.management-stock.destroy', $trStock->id) }}"
                                                class="d-inline" method="post">
                                                @csrf @method('delete')
                                            </form>
                                            <button type="submit" class="btn btn-danger btn-sm delete-button me-1"
                                                data-toggle="tooltip" data-placement="top" title="Hapus Transfer Stock">Hapus Data <i
                                                    class="fe fe-trash-2"></i></button>
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
        })

    </script>
    @endslot
</x-admin-layout>
