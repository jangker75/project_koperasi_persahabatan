<x-admin-layout titlePage="{{ $titlePage }}">
    <div class="row row-sm">
        <div class="col-lg-12">
            <a href="{{ route('admin.product.show', $prices[0]->product_id) }}" class="btn btn-danger mb-4">Kembali</a>
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
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th>Keuntungan</th>
                                    <th>Margin</th>
                                    <th>Pertama dibuat</th>
                                    <th>Terakhir Update</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($prices as $i => $price)
                                  <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td>{{ format_uang($price->cost)  }}</td>
                                    <td>{{ format_uang($price->revenue)  }}</td>
                                    <td>{{ format_uang($price->profit)  }}</td>
                                    <td>{{ $price->margin }}%</td>
                                    <td>{{ $price->created_at }}</td>
                                    <td>{{ $price->updated_at }}</td>
                                    <td>
                                      @if ($price->is_active == 1)
                                        <span class="text-success">Aktif</span>
                                        @else
                                        <span class="text-danger">Tidak Aktif</span>
                                      @endif
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
