<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fw-bold">{{ str("Laporan Penjualan Harian")->title() }}</h3>
                    <div class="card-options">
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.daily-sales-report.index')}}" method="get">
                        <div class="d-flex">
                            @csrf
                            <select name="storeid" class="form-control form-select border-primary w-25 me-3" id="storeid">
                                @foreach ($dropdown_store as $store)
                                    <option value="{{$store->id}}" {{$store->id == $storeid ? "selected" : ""}}>{{$store->name}}</option>
                                @endforeach
                            </select>
                            <input type="text" name="tanggal" autofocus id="tanggal"
                            class="form-control border-primary w-25 fc-datepicker me-3" placeholder="Pilih Tanggal (YYYY-MM-DD)"
                            autocomplete="off" value="{{$tanggal}}">
                            <button type="submit" class="btn btn-primary">Generate</button>
                        </div>
                    </form>
                    @if($result)
                    <div class="w-100 mt-5">
                        <h5 class="text-sm">Menampilkan Data Penjualan untuk tanggal <span class="text-danger">{{date('d F Y', strtotime($tanggal))}}</span></h3>
                        <div class="mt-3">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5 class="fw-bold">List Penjualan berdasarkan Metode Pembayaran</h5>
                                    <table class="table table-striped border">
                                        <thead class="table-primary">
                                            <th>No</th>
                                            <th>Kasir</th>
                                            <th>Metode</th>
                                            <th>Qty</th>
                                            <th>Subtotal</th>
                                        </thead>
                                        <tbody>
                                            <?php $totalamount = 0; ?> 
                                            @foreach ($calculate as $kcalc => $calc)
                                                <?php $totalamount += $calc->amount; ?>
                                                <tr>
                                                    <td>{{$kcalc + 1}}</td>
                                                    <td class="uppercase">KASIR <span class="text-danger">{{$calc->employee}}</span></td>
                                                    <td class="uppercase">{{$calc->name}}</td>
                                                    <td>{{$calc->totalOrder}}</td>
                                                    <td>{{ format_uang($calc->amount) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoo class="table-success">
                                            <tr class=" table-success table-active">
                                                <td colspan="4">TOTAL</td>
                                                <td>{{ format_uang($totalamount) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="col-sm-6">
                                    <h5 class="fw-bold">List Penjualan berdasarkan produk</h5>
                                    <table class="datatable table table-striped border" id="datatable">
                                        <thead>
                                            <th>No</th>
                                            <th>Produk</th>
                                            <th>Qty</th>
                                            <th>Subtotal</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($itemCalculate as $ktem => $item)
                                                <tr>
                                                    <td>{{$ktem+1}}</td>
                                                    <td>{{$item->productName}}</td>
                                                    <td>{{$item->qty}}</td>
                                                    <td>{{ format_uang($item->subtotal)}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
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
            $("#datatable").DataTable();

            $('.fc-datepicker').bootstrapdatepicker({
                todayHighlight: true,
                toggleActive: true,
                format: 'yyyy-mm-dd',
                autoclose: true,
            });
        })

    </script>
    @endslot
</x-admin-layout>
