<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fw-bold">{{ str("list Paylater")->title() }}</h3>
                    <div class="card-options">
                      <a href="{{ route('admin.request-order.index') }}" class="btn btn-primary">Refresh <i class="fa fa-refresh    "></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="w-100">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatable">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Order</th>
                                        <th>Pemohon</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Total</th>
                                        <th>Paylater</th>
                                        <th>Delivery</th>
                                        <th>Lunas</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $i => $order)
                                    <tr>
                                        <td>{{ $i+1 }}</td>
                                        <td>{{ $order->orderCode }}</td>
                                        <td>{{ $order->requesterName }}</td>
                                        <td>{{ $order->requestDate }}</td>
                                        <td>{{ format_uang($order->total) }}</td>
                                        <td>
                                          @if ($order->isPaylater == 1)
                                            <div class="btn btn-sm btn-info">Yes</div>
                                          @else
                                            <div class="btn btn-sm btn-warning">No</div>
                                          @endif
                                        </td>
                                        <td>
                                          @if ($order->isDelivery == 1)
                                            <div class="btn btn-sm btn-info">Yes</div>
                                          @else
                                            <div class="btn btn-sm btn-warning">No</div>
                                          @endif
                                        </td>
                                        <td>
                                          @if ($order->isPaid == 1)
                                            <div class="btn btn-sm btn-success">Lunas</div>
                                          @else
                                            <div class="btn btn-sm btn-danger">Belum Lunas</div>
                                          @endif
                                        </td>
                                        <td>
                                          <div class="btn btn-sm {{ $order->statusOrderColorButton }}">{{ $order->statusOrderName }}</div>
                                        </td>
                                        <td>
                                          <a href="{{ route('admin.request-order.detail', $order->orderCode) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
                                          @if ($order->statusOrderName == "success")
                                            <a href="{{ route('admin.print-receipt', $order->orderCode) }}" target="_blank" data-code="{{ $order->orderCode }}" class="btn btn-sm btn-info reject-order print-order"><i class="fa fa-print"></i></a>                                           
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
    </div>
    <x-slot name="scriptVendor">
        <script src="{{ asset('/assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    </x-slot>

    @slot('script')
    <script>
        $(document).ready(function () {
            $("#datatable").DataTable();
        })

    </script>
    @endslot
</x-admin-layout>
