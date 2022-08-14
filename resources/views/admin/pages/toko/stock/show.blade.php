<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Transfer Stock</div>
                    <div class="card-options">
                        <a href="{{ route('admin.management-stock.edit', $transferStock->id) }}"
                            class="btn btn-warning btn-sm">Edit Data Request</a>
                        @if ($transferStock->status_id == 3)
                        <a href="{{ url('admin/toko/confirm-ticket-transfer-stock/' . $transferStock->id) }}" class="btn btn-info btn-sm ms-2">Konfirmasi Tiket Transfer Stock</a>
                        @else
                        <a href="javascript:void(0)" class="btn btn-info btn-sm ms-2">Konfirmasi Ketersediaan Produk</a>
                        <a href="javascript:void(0)" class="btn btn-info btn-sm ms-2">Konfirmasi Penerimaan Produk</a>
                        <a href="javascript:void(0)" class="btn btn-success btn-sm ms-2">Print Data Transfer Stock</a>
                        @endif
                        <form action="{{ route('admin.management-stock.destroy', $transferStock->id) }}" class="d-inline"
                            method="post">
                            @csrf @method('delete')
                        </form>
                        <button type="submit" class="btn btn-danger btn-sm delete-button ms-2" data-toggle="tooltip"
                            data-placement="top" title="Hapus Transfer Stock">Hapus Data <i
                                class="fe fe-trash-2"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="w-100 mb-4">
                        <div class="table-responsive">
                            <table class="table w-100 table-striped" id="datatable">
                                <tbody>
                                    <tr>
                                        <td>Transfer Stock Kode</td>
                                        <td>:</td>
                                        <td>{{ $transferStock->transfer_stock_code }}</td>
                                    </tr>
                                    <tr>
                                        <td>Dari Toko</td>
                                        <td>:</td>
                                        <td>{{ $transferStock->FromStore->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tujuan Toko</td>
                                        <td>:</td>
                                        <td>{{ $transferStock->ToStore->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Request By</td>
                                        <td>:</td>
                                        <td>{{ $transferStock->Requester->getFullNameAttribute() }}</td>
                                    </tr>
                                    <tr>
                                        <td>Request Time</td>
                                        <td>:</td>
                                        <td>{{ $transferStock->req_date}}</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>:</td>
                                        <td>
                                            <div class="btn btn-warning">{{ $transferStock->Status->name }}</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="w-100 border">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="table-success fw-bold text-uppercase">
                                    <th>No</th>
                                    <th>Produk Name</th>
                                    <th>Jumlah diminta</th>
                                    <th>Jumlah tersedia</th>
                                    <th>Jumlah diterima</th>
                                </thead>
                                <tbody>
                                    @foreach ($transferStock->detailItem as $i => $item)
                                    <tr>
                                        <td>{{ $i+1 }}</td>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->request_qty }}</td>
                                        <td>{{ $item->available_qty }}</td>
                                        <td>{{ $item->receive_qty }}</td>
                                    </tr>
                                    @endforeach
                                    <tr></tr>
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
            
        })

    </script>
    @endslot
</x-admin-layout>
