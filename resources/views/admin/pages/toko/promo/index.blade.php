<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fw-bold">{{ str("list Promo terdaftar")->title() }}</h3>
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
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalStoreLabel">Create New Promo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form action="" id="storeForm">
                                        <div class="row">
                                            <input type="hidden" name="_method" id="method" value="post">
                                            <input type="hidden" name="id" id="id">
                                            <input class="form-control mb-4" name="name"
                                                placeholder="Masukan Judul" type="text">
                                            <div class="mt-4">Text Promo</div>
                                            <textarea name="text" id="text" class="form-control mb-4" cols="30" rows="5"
                                                placeholder="Masukan text"></textarea>
                                            <div class="mt-4">Gambar Promo</div>
                                            <div class="row mb-4">
                                              <div class="col-6">
                                                <img src="" id="displayImage" class="mb-4" alt="" height="240"
                                                style="display: none;">
                                              </div>
                                              <div class="col-6">
                                                <input type="file" class="dropify mb-4" name="cover" data-bs-height="180"
                                                data-max-file-size="2M" />
                                              </div>
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
                                        <th>Judul</th>
                                        {{-- <th>Status</th> --}}
                                        <th>Gambar</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($promos as $i => $promo)
                                    <tr>
                                        <td>{{ $i+1 }}</td>
                                        <td>{{ $promo->name }}</td>
                                        {{-- <td>
                                          @if ($promo->is_active == 1)
                                            aktif
                                          @else
                                            tidak aktif
                                          @endif
                                        </td> --}}
                                        <td>
                                          <img src="{{ route('showimage', $promo->image) }}" alt="" style="height: 72px;">
                                        </td>
                                        <td>
                                          @if ($promo->is_active == 1)
                                            <div class="form-group">
                                              <label class="custom-switch form-switch">
                                                  <input type="checkbox" name="custom-switch-radio" class="custom-switch-input" data-id="{{ $promo->id }}" checked>
                                                  <span class="custom-switch-indicator"></span>
                                                  <span class="custom-switch-description" data-id="{{ $promo->id }}">Aktif</span>
                                              </label>
                                          </div>
                                          @else
                                            <div class="form-group">
                                              <label class="custom-switch form-switch">
                                                  <input type="checkbox" name="custom-switch-radio" class="custom-switch-input" data-id="{{ $promo->id }}">
                                                  <span class="custom-switch-indicator"></span>
                                                  <span class="custom-switch-description" data-id="{{ $promo->id }}">Tidak Aktif</span>
                                              </label>
                                          </div>
                                          @endif
                                        </td>
                                        <td>
                                            <span class="btn btn-sm btn-primary btn-detail" id="{{ $promo->id }}">Lihat
                                                Detail</span>
                                            <form action="{{ route('admin.promo.destroy', $promo->id) }}"
                                                class="d-inline" method="post">
                                                @csrf @method('delete')
                                            </form>
                                            <button type="submit" class="btn btn-danger btn-sm delete-button me-1"
                                                data-toggle="tooltip" data-placement="top" title="Hapus Promo"><i
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
        <script src="https://cdn.tiny.cloud/1/2yzm6dte4n45dr6lv2g3t2ztb6yfqvo31pdgr4329i0dmuti/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"></script>
    </x-slot>

    @slot('script')
    <script>
        $(document).ready(function () {
            $("#datatable").DataTable();

            $("#showModal").click(function () {
                $("#storeForm")[0].reset();
                $("#displayImage").hide();
                tinymce.get('text').setContent('')
            })

            $('.btn-detail').click(function () {
                let id = $(this).attr('id');

                $("#method").val('put')
                $("#id").val(id)

                $.ajax({
                    type: "GET",
                    url: "{{ url('api/promo') }}/" + id,
                    dataType: "json",
                    success: function (response) {
                        console.log(response)
                        $("input[name='name']").val(response.data.name)
                        $("textarea[name='text']#text").val(response.data.text)
                        tinymce.get('text').setContent(response.data.text)
                        $("#displayImage").attr("src", "{{ asset('storage') }}/" + response
                            .data.image)
                        $("#displayImage").show();
                        $('#modalStore').modal('show')
                    },
                    error: function (response) {

                    }
                });

            })

            // for description
            let tinyMCE = tinymce.init({
                selector: 'textarea#text',
                menubar: false,
                height: 320,
                toolbar: 'undo redo ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | '
            });

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
                let name = $(this).find('input').val();
                let formData = new FormData(this);

                let method = $('#method').val();
                // console.log(method)
                let url = "";
                if (method == "post") {
                    url = "{{ url('api/promo') }}"
                } else {
                    let ids = $(this).find("input[name='id']").val()
                    url = "{{ url('api/promo') }}/" + ids;
                }

                // console.log(formData);
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
                        location.reload();
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

            $(".custom-switch-input").click(function(){
              let id = $(this).data("id")
              if ($(this).is(":checked")) {
                $(".custom-switch-description[data-id=" + id + "]").html("Aktif")
              } else {
                $(".custom-switch-description[data-id=" + id + "]").html("Tidak Aktif")
              }

              $.ajax({
                    type: "GET",
                    url: "{{ url('api/change-status-promo') }}/" + id,
                    success: function (response) {
                        swal({
                            title: "Success!",
                            text: response.message,
                            type: "success"
                        });
                        // getTable()
                        // $("#modalStore").modal('hide')
                    },
                    error: function (response) {
                        swal({
                            title: "Failed!",
                            text: response.message,
                            type: "failed"
                        });
                        // $("#modalStore").modal('hide')
                    }
                });
            })
        })

    </script>
    @endslot
</x-admin-layout>
