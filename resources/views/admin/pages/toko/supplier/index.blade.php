<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fw-bold">{{ str("list Pemasok terdaftar")->title() }}</h3>
                </div>
                <div class="card-body">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                        data-bs-target="#modalStore">
                        Create New Data
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="modalStore" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="modalStoreLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalStoreLabel">Create New Brand</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form action="" id="storeForm">
                                        <div class="row">
                                            <input type="hidden" name="_method" id="method" value="post">
                                            <input type="hidden" name="id" id="id">
                                            <div class="input-group mb-4">
                                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-bank"></i></span>
                                                <input class="form-control" name="name" placeholder="{{ __('supplier.name') }} Baru" type="text" aria-describedby="basic-addon1">
                                            </div>
                                            <div class="input-group mb-4">
                                                <span class="input-group-text" id="basic-addon1"><i class="fe fe-user"></i></span>
                                                <input class="form-control" name="contact_name" placeholder="{{ __('supplier.contact_name') }} Baru" type="text" aria-describedby="basic-addon1">
                                            </div>
                                            <div class="input-group mb-4">
                                                <span class="input-group-text" id="basic-addon1"><i class="fe fe-map-pin"></i></span>
                                                <input class="form-control" name="contact_address" placeholder="{{ __('supplier.contact_address') }} Baru" type="text" aria-describedby="basic-addon1">
                                            </div>
                                            <div class="input-group mb-4">
                                                <span class="input-group-text" id="basic-addon1"><i class="fe fe-phone"></i></span>
                                                <input class="form-control" name="contact_phone" placeholder="{{ __('supplier.contact_phone') }} Baru" type="text" aria-describedby="basic-addon1">
                                            </div>
                                            <div class="input-group mb-4">
                                                <span class="input-group-text" id="basic-addon1"><i class="fe fe-link"></i></span>
                                                <input class="form-control" name="contact_link" placeholder="{{ __('supplier.contact_link') }} Baru" type="text" aria-describedby="basic-addon1">
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100">Submit New Data</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-100">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatable">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>{{ __('supplier.name') }}</th>
                                        <th>{{ __('supplier.supplier_code') }}</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($suppliers as $i => $supp)
                                    <tr>
                                        <td>{{ $i+1 }}</td>
                                        <td>{{ $supp->name }}</td>
                                        <td>{{ $supp->supplier_code }}</td>
                                        <td>
                                            <span class="btn btn-sm btn-primary btn-detail"
                                                id="{{ $supp->id }}">Lihat Detail</span>
                                            <form action="{{ route('admin.supplier.destroy', $supp->id) }}"
                                                class="d-inline" method="post">
                                                @csrf @method('delete')
                                            </form>
                                            <button type="submit" class="btn btn-danger btn-sm delete-button me-1"
                                                data-toggle="tooltip" data-placement="top" title="Hapus Produk"><i
                                                    class="fe fe-trash-2"></i></button>
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
