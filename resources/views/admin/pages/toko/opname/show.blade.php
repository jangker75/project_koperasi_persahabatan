<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="mb-4">
                <a href="{{ route('admin.opname.index') }}" class="btn btn-danger">kembali</a>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Opname</div>
                    <div class="card-options">
                        @if ($opname->is_commit == false)
                        <div class="btn btn-sm mx-1 btn-primary" id="commit">Commit Opname</div>
                        <a href="{{ route('admin.opname.edit', $opname->id) }}" class="btn btn-sm mx-1 btn-warning">Edit Opname</a>
                        <div class="btn btn-sm mx-1 btn-danger" id="delete">Hapus Opname</div>
                        @endif
                        <a href="{{ route('admin.opname.print', $opname->id) }}" class="btn btn-sm mx-1 btn-info">Print Opname</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="w-100 mb-4">
                      @if ($opname->is_commit == false)
                      <span class="text-danger">*Status opname ini masih "Placed", stock product belum diupdate jika opname ini belum di commit</span>
                      @endif
                        <div class="table-responsive">
                            <table class="table w-100 table-striped" id="datatable">
                                <tbody>
                                    <tr>
                                        <td>Kode Opname</td>
                                        <td>:</td>
                                        <td>{{ $opname->opname_code }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Opname</td>
                                        <td>:</td>
                                        <td>{{ $opname->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <td>Lokasi Toko</td>
                                        <td>:</td>
                                        <td>{{ $opname->store->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Nama Petugas</td>
                                        <td>:</td>
                                        <td>{{ $opname->employee->full_name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Kerugian</td>
                                        <td>:</td>
                                        <td>{{ format_uang($opname->total_price) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Catatan</td>
                                        <td>:</td>
                                        <td>{{ $opname->note }}</td>
                                    </tr>
                                    <tr>
                                      <td>Status</td>
                                      <td>:</td>
                                      <td>
                                        @if ($opname->is_commit == false)
                                          <span class="text-danger fw-bold">Placed</span>
                                          @else
                                          <span class="text-success fw-bold">Commit</span>
                                        @endif
                                      </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="w-100 border">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="table-primary fw-bold text-uppercase">
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Jumlah</th>
                                    <th>Tipe</th>
                                    <th>Expired</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                    <th>Catatan</th>
                                </thead>
                                <tbody>
                                    @foreach ($opname->detail as $i => $detail)
                                      <tr>
                                        <td>{{ $i+1 }}</td>
                                        <td>{{ $detail->product->name }}</td>
                                        <td>{{ $detail->quantity }}</td>
                                        <td>{{ $detail->type }}</td>
                                        <td>
                                          @if ($detail->is_expired == true)
                                            <span class="text-success">Ya</span>
                                          @else
                                            <span class="text-danger">Tidak</span>
                                          @endif
                                        </td>
                                        <td>{{ format_uang($detail->price) }}</td>
                                        <td>{{ format_uang($detail->amount) }}</td>
                                        <td>{{ $detail->description }}</td>
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

    <x-slot name="style">
        
    </x-slot>

    <x-slot name="scriptVendor">
        <script src="{{ asset('/assets/plugins/fileuploads/js/fileupload.js') }}"></script>
        <script src="{{ asset('../assets/plugins/select2/select2.full.min.js') }}"></script>
    </x-slot>

    @slot('script')
    <script>
      $(document).ready(function(){
        $("#delete").click(function(){
          swal({
            title: "Anda yakin?",
            text: "Opname akan dihapus?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Ya, lanjutkan',
            cancelButtonText: "Tidak, batalkan",
            closeOnConfirm: false,
            closeOnCancel: false
          }, function(isConfirm) {
            if (isConfirm) {
              let param = {
                '_method': 'DELETE'
              };
              $.ajax({
                  type: "POST",
                  processData: false,
                  contentType: 'application/json',
                  data: JSON.stringify(param),
                  cache: false,
                  url: "{{ url('api/opname') }}/{{ $opname->id }}",
                  dataType: "json",
                  enctype: 'multipart/form-data',
                  success: function (response) {
                      swal({
                          title: "Sukses",
                          text: response.message,
                          type: "success"
                      });
                      
                      setTimeout(function () {
                          location.reload();
                      }, 2500)
                  },
                  error: function (response) {
                      swal({
                          title: "Gagal",
                          text: response.responseJSON.message,
                          type: "error"
                      });
                  }
              });
            } else {
              swal("Cancelled", "Delete dibatalkan", "error");
              return false;
            }
          })
        })
        $("#commit").click(function(){
          swal({
            title: "Anda yakin?",
            text: "setelah opname di commit, maka anda tidak bisa edit atau hapus opname ini",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Ya, lanjutkan',
            cancelButtonText: "Tidak, batalkan",
            closeOnConfirm: false,
            closeOnCancel: false
          }, function(isConfirm) {
            if (isConfirm) {
              
              $.ajax({
                  type: "GET",
                  processData: false,
                  contentType: 'application/json',
                  cache: false,
                  url: "{{ url('api/opname-commit') }}/{{ $opname->id }}",
                  dataType: "json",
                  enctype: 'multipart/form-data',
                  success: function (response) {
                      swal({
                          title: "Sukses",
                          text: response.message,
                          type: "success"
                      });
                      
                      setTimeout(function () {
                          location.reload();
                      }, 2500)
                  },
                  error: function (response) {
                      swal({
                          title: "Gagal",
                          text: response.responseJSON.message,
                          type: "error"
                      });
                  }
              });
            } else {
              swal("Cancelled", "Commit dibatalkan", "error");
              return false;
            }
          })
        })
      })
    </script>
    @endslot
</x-admin-layout>
