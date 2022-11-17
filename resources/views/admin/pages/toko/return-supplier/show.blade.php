<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fw-bold">{{ str("Detail Return Supplier " . $returnSupplier->id)->title() }}</h3>
                    <div class="card-options">
                      <div class="btn btn-primary">Konfirmasi Tiket</div>
                    </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <tbody>
                        <tr>Retun Supplier Code</tr>
                        <tr>:</tr>
                        <tr>{{ $returnSupplier->return_supplier_code }}</tr>
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="scriptVendor">
        <script src="{{ asset('/assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    </x-slot>

    @slot('script')
    <script>

    </script>
    @endslot
</x-admin-layout>
