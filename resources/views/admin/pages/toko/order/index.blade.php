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

                    <div class="w-100">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatable">
                                <thead class="table-primary">
                                    <tr>
                                        <th></th>
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
    @include('admin.pages.toko.order.index-script-datatable')
    <script>
        $(document).ready(function () {
            let priceAll = [];
            let totalPrice = 0;
            let dataPaylater = [];
            let totalPaylater = 0;

            $.ajax({
                url: "{{ url('admin/datatables-order') }}",
                method: "GET"
            }).done(function (response) {
                priceAll = response.data.map(item => parseInt(item['total']));
                totalPrice = priceAll.reduce((partialSum, a) => partialSum + a, 0);
                $("#totalPrice").html(formatRupiah(String(totalPrice), "Rp "));

                dataPaylater = response.data.filter(function(data){
                  return data.isPaylater == 'ya'
                })
                dataPaylater = dataPaylater.map(item => parseInt(item['total']))
                totalPaylater = dataPaylater.reduce((partialSum, a) => partialSum + a, 0);
                // console.log(dataPaylater);
                // console.log(totalPaylater);
                $("#totalPaylater").html(formatRupiah(String(totalPaylater), "Rp "));
            });

            $('input[name="daterange"]').change(function () {
                let value = $(this).val();
                value = value.split('to')
                value[0] = value[0].replace(" ", "");
                value[1] = value[1].replace(" ", "");
                value = value.join(',');

                $.ajax({
                    url: "{{ url('admin/datatables-order') }}?date=" + value,
                    method: "GET"
                }).done(function (response) {
                    priceAll = response.data.map(item => item['total']);
                    totalPrice = priceAll.reduce((partialSum, a) => partialSum + a, 0);
                    $("#totalPrice").html(formatRupiah(String(totalPrice), "Rp "));

                    dataPaylater = response.data.filter(function(data){
                      return data.isPaylater == 'ya'
                    })
                    dataPaylater = dataPaylater.map(item => parseInt(item['total']))
                    totalPaylater = dataPaylater.reduce((partialSum, a) => partialSum + a, 0);
                    // console.log(dataPaylater);
                    // console.log(totalPaylater);
                    $("#totalPaylater").html(formatRupiah(String(totalPaylater), "Rp "));
                });

            })
        })

    </script>
    @endslot
</x-admin-layout>
