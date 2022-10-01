<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fw-bold">{{ str("list Metode Pembayaran terdaftar")->title() }}</h3>
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
                                    <h5 class="modal-title" id="modalStoreLabel">Create New Metode Pembayaran</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form action="" id="storeForm">
                                        <div class="row">
                                            <input class="form-control mb-4" name="name" placeholder="Nama Metode Pembayaran Baru"
                                                type="text">
                                            <input class="form-control mb-4" name="credentials" placeholder="Kredensi Metode Pembayaran Baru"
                                                type="text">
                                            <input class="form-control mb-4" name="description" placeholder="Deskripsi Metode Pembayaran Baru"
                                                type="text">
                                            <button type="submit" class="btn btn-primary w-100">Submit New Data</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-100" id="fieldTable">

                    </div>
                </div>
            </div>
        </div>
    </div>
    @slot('script')
    <script>
      $(document).ready(function () {
                getTable()

                function getTable() {

                    $.ajax({
                        type: "POST",
                        url: "{{ url('api/payment-data-editable') }}",
                        cache: "false",
                        data: {
                            'link': "{{ $link }}",
                        },
                        datatype: "html",
                        beforeSend: function () {
                            //something before send
                        },
                        success: function (data) {
                            $('#fieldTable').html("");
                            $('#fieldTable').html(data);
                        }
                    });
                }

                $("#storeForm").submit(function (e) {
                    e.preventDefault();

                    let name = $(this).find('input').val();
                    let data = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: "{{ $link }}",
                        data: data,
                        dataType: "json",
                        success: function (response) {
                            swal({
                                title: "Success!",
                                text: response.message,
                                type: "success"
                            });
                            getTable()
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

                    $(this)[0].reset();
                })
            })
    </script>
    @endslot
</x-admin-layout>
