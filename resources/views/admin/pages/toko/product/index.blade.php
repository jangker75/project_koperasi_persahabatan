<x-admin-layout titlePage="{{ $titlePage }}">
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span class="card-title">Table untuk {{ $titlePage }}</span>
                    <div class="d-flex">
                        <a href="{{ route('admin.product.create') }}">
                            <button class="btn btn-success me-3">Buat Produk Baru</button>
                        </a>
                        
                        <a href="{{ route("admin.form-label-harga") }}">
                            <button class="btn btn-info me-3">Cetak Label Produk</button>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap border-bottom" id="datatable">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>#</th>
                                    <th>{{ __('product.name') }}</th>
                                    <th>{{ __('product.sku') }}</th>
                                    <th>{{ __('product.unit_measurement') }}</th>
                                    <th>{{ __('product.brand') }}</th>
                                    <th>{{ __('product.price') }}</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @slot('script')
    @include('admin.pages.toko.product.index-script-datatable')
    <script>
        $(document).ready(function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
            $("#datatable").DataTable();
        })

    </script>
    @endslot
</x-admin-layout>
