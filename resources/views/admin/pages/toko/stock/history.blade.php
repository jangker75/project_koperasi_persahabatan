<x-admin-layout titlePage="{{ $titlePage }}">
    <div class="row row-sm">
        <div class="col-lg-12">
            <a href="{{ route('admin.product.show', $historyStock[0]->product_id) }}" class="btn btn-danger mb-4">Kembali</a>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span class="card-title">Table untuk {{ $titlePage }}</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap border-bottom" id="datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Tipe</th>
                                    <th>Jumlah Selisih</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($historyStock as $k => $stock)
                                  <tr>
                                    <td>{{ $k+1 }}</td>
                                    <td>{{ $stock->title }}</td>
                                    <td>{{ $stock->type }}</td>
                                    <td>{{ $stock->qty }}</td>
                                    <td>{{ $stock->created_at }}</td>
                                  </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @slot('script')
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
