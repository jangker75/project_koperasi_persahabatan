<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Riwayat Order Supplier</div>
                    <div class="card-options">
                      <a href="{{ route('admin.order-supplier.create') }}" class="btn btn-primary">Buat Order Baru &plus;</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="w-100">
                        <div class="table-responsive">
                            <table class="table w-100" id="datatable">
                                <thead class="table-primary">
                                    <th>No</th>
                                    <th>Kode Order</th>
                                    <th>Nama Supplier</th>
                                    <th>Tanggal Order</th>
                                    <th>Pembuat Order</th>
                                    <th>Tanggal Terima</th>
                                    <th>Lokasi Terima</th>
                                    <th>Sudah Lunas</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @if (!$orderSuppliers)
                                      <tr>
                                        <td colspan="9">Belum ada Order Supplier</td>
                                      </tr>
                                    @else
                                      @foreach ($orderSuppliers as $i => $order)
                                        <tr>
                                          <td>{{ $i+1 }}</td>
                                          <td>{{ $order->order_supplier_code }}</td>
                                          <td>{{ $order->supplier->name }}</td>
                                          <td>{{ $order->order_date }}</td>
                                          <td>{{ $order->requester->full_name }}</td>
                                          <td>{{ $order->received_date }}</td>
                                          <td>{{ $order->toStore->name }}</td>
                                          <td>
                                            @if ($order->is_paid)
                                              <div class="btn btn-success btn-sm">Lunas</div>
                                            @else
                                              <div class="btn btn-danger btn-sm">Belum Lunas</div>
                                            @endif
                                          </td>
                                          <td>
                                            <div class="btn btn-sm btn-primary-light">{{ $order->status->name }}</div>
                                          </td>
                                          <td>
                                            <a href="{{ route("admin.order-supplier.show", $order->id) }}" target="_blank" class="btn btn-sm mb-1 me-1 btn-info">Lihat Detail</a>
                                            @if (($order->is_paid == null || $order->is_paid == 0) && $order->status->name == "Receive")
                                              <div class="btn btn-sm mb-1 me-1 btn-warning btn-paid" data-id="{{ $order->id }}">Ubah Ke Lunas</div>
                                            @endif
                                          </td>
                                        </tr>
                                      @endforeach
                                    @endif
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
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </x-slot>

    @slot('script')
    <script>
        $(document).ready(function () {
            let originStore;
            let listProduk;

            $("#datatable").DataTable();
            $("#datatable2").DataTable();

            $('.select2').select2({
                minimumResultsForSearch: '',
                width: '100%'
            });
            $("body").on("click", ".addRows", function () {
                let element = $(this).closest(".rowList").html();
                element = `<tr class="rowList">` + element + `</tr>`;
                $("#bodyTable").append(element);
            })
            $("body").on("click", ".deleteRows", function () {
                var numItems = $('.rowList').length;
                if (numItems > 1) {
                    $(this).closest(".rowList").remove();
                }
            })

            $("select[name='originStore']").change(function () {
                let value = $(this).val();
                originStore = value;
            })

            $(".product-list").keyup(function () {
                let value = $(this).val()
                if (value > 4) {
                    $(this).closest(".card-search-product").toggle();
                }
            })

            $("body").on("click", ".btn-paid", function(){
              let id = $(this).data('id');
              
              Swal.fire({
                title: 'Apa anda yakin?',
                text: "Status akan diubah menjadi lunas",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Lanjut ubah status'
              }).then((result) => {
                if (result.isConfirmed) {
                  let url = "{{ url('api/order-supplier-paid') }}/" + id
                  $.ajax({
                      type: "GET",
                      url: url,
                      success: function (response) {
                        swal({
                            title: "Sukses",
                            text: response.message,
                            type: "success"
                        });
                          
                          setTimeout(function () {
                              // window.location.replace("{{ url('admin/toko/order-supplier') }}");
                          }, 1000)
                      },
                      error: function (response) {
                        console.log(response)
                          swal({
                              title: "Gagal",
                              text: response.responseJSON.message,
                              type: "error"
                          });
                      }
                  });
                }
              })
            })
        })

    </script>
    @endslot
</x-admin-layout>
