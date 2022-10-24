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
                        <a class="modal-effect btn btn-info d-grid mb-3"
                            data-bs-effect="effect-slide-in-right" data-bs-toggle="modal" href="#modaldemo8">Cetak Produk</a>
                        <div class="modal fade" id="modaldemo8" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered text-center" role="document">
                                <div class="modal-content modal-content-demo">
                                    <div class="modal-header">
                                        <h6 class="modal-title">Message Preview</h6><button aria-label="Close"
                                            class="btn-close" data-bs-dismiss="modal"><span
                                                aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>Why We Use Electoral College, Not Popular Vote</h6>
                                        <p>It is a long established fact that a reader will be distracted by the
                                            readable content of a page when looking at its layout. The point of
                                            using Lorem Ipsum is that it has a more-or-less normal distribution of
                                            letters, as opposed to
                                            using 'Content here, content here', making it look like readable
                                            English.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary">Save changes</button> <button
                                            class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <a href="#">
                            <button class="btn btn-info me-3">Cetak Data Produk</button>
                        </a> --}}
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
