<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fw-bold">{{ str("List Result")->title() }}</h3>
                    <div class="card-options">
                      <a href="{{ route('admin.return-supplier.create') }}" class="btn btn-primary">Buat Data Baru</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="w-100">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatable">
                                <thead>
                                  <th></th>
                                  <th>No</th>
                                  <th>Kode</th>
                                  <th>tanggal</th>
                                  <th>supplier</th>
                                  <th>toko</th>
                                  <th>requester</th>
                                  <th>catatan</th>
                                  <th>jumlah produk</th>
                                  <th>status</th>
                                  <th>Action</th>
                                </thead>
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
    @include('admin.pages.toko.return-supplier.index-script-datatable')
    <script>

    </script>
    @endslot
</x-admin-layout>
