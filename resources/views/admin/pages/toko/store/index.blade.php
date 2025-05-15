<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fw-bold">{{ str("list Toko terdaftar")->title() }}</h3>
                </div>
                <div class="card-body">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary mb-3" id="showModal" data-bs-toggle="modal"
                        data-bs-target="#modalStore">
                        Create New Data
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="modalStore" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="modalStoreLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalStoreLabel">Create New Toko</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form action="" id="storeForm">
                                        <div class="row">
                                            <input type="hidden" name="_method" id="method" value="post">
                                            <input type="hidden" name="id" id="id">
                                            <input class="form-control mb-4" name="name"
                                                placeholder="{{ __('store.name') }}" type="text">
                                            <textarea name="location" id="" class="form-control mb-4" cols="30" rows="5"
                                                placeholder="{{ __('store.location') }}"></textarea>
                                            <select name="manager_id" id="" class="form-control form-select mb-4">
                                                @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}">{{ $employee->first_name }}
                                                    {{ $employee->last_name }}</option>
                                                @endforeach
                                            </select>
                                            <img src="" id="displayImage" class="mb-4" alt="" height="240"
                                                style="display: none;">
                                            <input type="file" class="dropify mb-4" name="cover" data-bs-height="180"
                                                data-max-file-size="2M" />
                                            <button type="submit" class="btn btn-primary w-100" id="buttonSubmitForm">Submit New Data</button>
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
                                        <th>{{ __("store.name") }}</th>
                                        <th>{{ __("store.store_code") }}</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stores as $i => $store)
                                    <tr>
                                        <td>{{ $i+1 }}</td>
                                        <td>{{ $store->name }}</td>
                                        <td>{{ $store->store_code }}</td>
                                        <td>
                                            <span class="btn btn-sm btn-primary btn-detail" id="{{ $store->id }}">Lihat
                                                Detail</span>
                                            <form action="{{ route('admin.store.destroy', $store->id) }}"
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
                    url: "{{ url('api/store') }}/" + id,
                    dataType: "json",
                    success: function (response) {
                        console.log(response)
                        $("input[name='name']").val(response.data.name)
                        $("textarea[name='location']").val(response.data.location)
                        $("select[name='manager_id']").val(response.data.manager_id)
                        $("#displayImage").attr("src", "{{ asset('storage') }}/" + response
                            .data.image)
                        $("#displayImage").show();
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
                e.preventDefault();
                $("#buttonSubmitForm").prop('disabled', true);
                let name = $(this).find('input').val();
                let formData = new FormData(this);

                let method = $('#method').val();
                let url = "";
                if (method == "post") {
                    url = "{{ url('api/store') }}"
                } else {
                    let ids = $(this).find("input[name='id']").val()
                    url = "{{ url('api/store') }}/" + ids;
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
                        $("#buttonSubmitForm").prop('disabled', false);
                        swal({
                            title: "Failed!",
                            text: 'Gagal menambah toko',
                            type: "error"
                        });
                        $("#modalStore").modal('hide')
                
                    }
                });

            })
        })

    </script>
    @endslot
</x-admin-layout>
