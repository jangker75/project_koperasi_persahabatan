<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fw-bold">{{ str("list Paylater")->title() }}</h3>
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
                                          @if ($order->statusOrderName !== "success")
                                            <a href="" class="btn btn-sm btn-danger reject-order">Tolak Order</a>                                            
                                            <a href="" class="btn btn-sm btn-success approve-order">Terima Order</a>                                            
                                          @endif
                                          <a href="{{ route('admin.request-order.detail', $order->orderCode) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
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

            $("#showModal").click(function () {
                $("#storeForm")[0].reset();
                $("#displayImage").hide();
            })

            $('.btn-detail').click(function () {
                let id = $(this).attr('id');

                $("#method").val('put')
                $("#id").val(id)

                $.ajax({
                    type: "GET",
                    url: "{{ url('api/supplier') }}/" + id,
                    dataType: "json",
                    success: function (response) {
                        console.log(response)
                        $("input[name='name']").val(response.data.name)
                        $("input[name='contact_name']").val(response.data.contact_name)
                        $("input[name='contact_address']").val(response.data.contact_address)
                        $("input[name='contact_phone']").val(response.data.contact_phone)
                        $("input[name='contact_link']").val(response.data.contact_link)
                        
                        $('#modalStore').modal('show')
                    },
                    error: function (response) {

                    }
                });

            })


            // input image
            $('.dropify').dropify({
                messages: {
                    'default': 'Drag and drop a file here or click',
                    'replace': 'Drag and drop or click to replace',
                    'remove': 'Remove',
                    'error': 'Ooops, something wrong appended.'
                },
                error: {
                    'fileSize': 'The file size is too big (2M max).'
                }
            });

            // send store / update
            $("#storeForm").submit(function (e) {
                // e.preventDefault()
                let name = $(this).find('input').val();
                let formData = new FormData(this);

                let method = $('#method').val();
                let url = "";
                if (method == "store") {
                    url = "{{ url('api/supplier') }}"
                } else {
                    let ids = $(this).find("input[name='id']").val()
                    url = "{{ url('api/supplier') }}/" + ids;
                }
                $.ajax({
                    type: "POST",
                    processData: false,
                    contentType: false,
                    cache: false,
                    url: url,
                    data: formData,
                    dataType: "json",
                    enctype: 'multipart/form-data',
                    success: function (response) {
                        swal({
                            title: "Success!",
                            text: response.message,
                            type: "success"
                        });
                        // getTable()
                        $("#modalStore").modal('hide')
                    },
                    error: function (response) {
                        swal({
                            title: "Failed!",
                            text: response.message,
                            type: "failed"
                        });
                        $("#modalStore").modal('hide')
                    }
                });

            })
        })

    </script>
    @endslot
</x-admin-layout>
