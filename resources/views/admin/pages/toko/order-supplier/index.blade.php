<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Order Supplier</div>
                    <div class="card-options">
                        <a href="{{ route('admin.order-supplier.create') }}" class="btn btn-primary btn-sm">Buat Order Supplier +</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="w-100">
                        <div class="table-responsive">
                            <table class="table w-100 " id="datatable2">
                                <thead class="table-success fw-bold text-uppercase">
                                    <th>No</th>
                                    <th>Kode</th>p
                                    <th>Dari Supplier</th>
                                    <th>Tujuan Toko</th>
                                    <th>Tanggal</th>
                                    <th>Requester</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($orderSupplier as $i => $order)
                                    <tr>
                                        <td>{{ $i+1 }}</td>
                                        <td>{{ $order->order_supplier_code }}</td>
                                        <td>{{ $order->supplier->name }}</td>
                                        <td>{{ $order->toStore->name }}</td>
                                        <td>{{ $order->order_date }}</td>
                                        <td>{{ $order->req_empl_id }}</td>
                                        <td>
                                            
                                            <a href="{{ route('admin.order-supplier.show', $order->id) }}" class="btn btn-success btn-sm me-1" data-toggle="tooltip"
                                                data-placement="top" title="Edit Data Transfer Stock">Detail Transfer Stock <i
                                                    class="fe fe-edit"></i></a>
                                            <form action="{{ route('admin.order-supplier.destroy', $order->id) }}"
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
