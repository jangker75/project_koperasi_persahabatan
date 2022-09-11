<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Riwayat Order Supplier</div>
                    <div class="card-options">
                      <a href="{{ route('admin.order-supplier.create') }}" class="btn btn-primary">Buat Order Baru &plus;</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="w-100">
                        <div class="table-responsive">
                            <table class="table w-100" id="datatable">
                                <thead class="table-primary">
                                    <th>No</th>
                                    <th>Kode Order</th>
                                    <th>Nama Supplier</th>
                                    <th>Tanggal Order</th>
                                    <th>Pembuat Order</th>
                                    <th>Tanggal Terima</th>
                                    <th>Lokasi Terima</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @if (!$orderSuppliers)
                                      <tr>
                                        <td colspan="9">Belum ada Order Supplier</td>
                                      </tr>
                                    @else
                                      @foreach ($orderSuppliers as $i => $order)
                                        <tr>
                                          <td>{{ $i+1 }}</td>
                                          <td>{{ $order->order_supplier_code }}</td>
                                          <td>{{ $order->supplier->name }}</td>
                                          <td>{{ $order->order_date }}</td>
                                          <td>{{ $order->requester->full_name }}</td>
                                          <td>{{ $order->received_date }}</td>
                                          <td>{{ $order->toStore->name }}</td>
                                          <td>
                                            <div class="btn btn-sm btn-primary-light">{{ $order->status->name }}</div>
                                          </td>
                                          <td>
                                            <a href="{{ route("admin.order-supplier.show", $order->id) }}" class="btn btn-sm btn-info">Lihat Detail</a>
                                          </td>
                                        </tr>
                                      @endforeach
                                    @endif
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
