<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fw-bold">{{ str("list Kategori Produk terdaftar")->title() }}</h3>
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
                                    <h5 class="modal-title" id="modalStoreLabel">Create New Kategori</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="" id="storeForm">
                                        <div class="row">
                                            <input type="hidden" name="_method" id="method" value="store">
                                            <input type="hidden" name="id" id="id">
                                            <input class="form-control mb-4" name="name" placeholder="Kategori Baru"
                                                type="text">
                                            <textarea name="description" id="" class="form-control mb-4" cols="30"
                                                rows="5" placeholder="Deskripsi Kategori"></textarea>
                                            <img src="" id="displayImage" class="mb-4" alt="" height="240"
                                                style="display: none;">
                                            <input type="file" class="dropify" name="cover" data-bs-height="180"
                                                data-max-file-size="2M" />
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
                                        <th>Nama</th>
                                        <th>Deskripsi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $i => $category)
                                    <tr>
                                        <td>{{ $i+1 }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->description }}</td>
                                        <td>
                                            <span class="btn btn-sm btn-primary btn-detail"
                                                id="{{ $category->id }}">Lihat Detail</span>
                                            <form action="{{ route('admin.category.destroy', $category->id) }}"
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
                    url: "{{ url('api/category') }}/" + id,
                    dataType: "json",
                    success: function (response) {
                        console.log(response)
                        $("input[name='name']").val(response.data.name)
                        $("textarea[name='description']").val(response.data.description)
                        $("#displayImage").attr("src", "{{ asset('storage') }}/" + response
                            .data.cover)
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
                let name = $(this).find('input').val();
                let formData = new FormData(this);

                let method = $('#method').val();
                let url = "";
                if (method == "store") {
                    url = "{{ url('api/category') }}"
                } else {
                    let ids = $(this).find("input[name='id']").val()
                    url = "{{ url('api/category') }}/" + ids;
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
