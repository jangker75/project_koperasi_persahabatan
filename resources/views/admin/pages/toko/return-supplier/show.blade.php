<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fw-bold">{{ str("Detail Return Supplier " . $returnSupplier->id)->title() }}</h3>
                    <div class="card-options">
                      <form action="{{ route('admin.return-supplier.destroy', $returnSupplier->id) }}" class="d-inline"
                          method="post">
                          @csrf @method('delete')
                          <button type="submit" class="btn btn-danger me-1" data-toggle="tooltip"
                              data-placement="top" title="Hapus Return"
                              onclick="if(!confirm('Apa anda yakin?'))return false;"
                              >Hapus/Batalkan Return <i
                                  class="fe fe-trash-2"></i></button>
                      </form>
                    </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <tbody>
                        <tr>
                          <td>Kode Return</td>
                          <td>:</td>
                          <td><span class="fw-bold">{{ $returnSupplier->return_supplier_code }}</span></td>
                        </tr>
                        <tr>
                          <td>Tanggal Return</td>
                          <td>:</td>
                          <td><span class="fw-bold">{{ $returnSupplier->created_at }}</span></td>
                        </tr>
                        <tr>
                          <td>Requester Return</td>
                          <td>:</td>
                          <td><span class="fw-bold">{{ $returnSupplier->employee->getFullNameAttribute() }}</span></td>
                        </tr>
                        <tr>
                          <td>Catatan Return</td>
                          <td>:</td>
                          <td><span class="fw-bold">{{ $returnSupplier->note }}</span></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="my-4">
                    <h5 class="h5 fw-bold">Detail Barang Return</h5>
                    <div class="table-responsive">
                      <table class="table">
                        <thead class="table-primary">
                          <th>No</th>
                          <th>Nama</th>
                          <th>sku</th>
                          <th>Jumlah</th>
                          <th>Deskripsi</th>
                        </thead>
                        <tbody>
                          @foreach ($returnSupplier->details as $i => $detail)
                            <tr>
                              <td>{{ $i+1; }}</td>
                              <td>{{ $detail->product_name }}</td>
                              <td>{{ $detail->product_sku }}</td>
                              <td>{{ $detail->qty }}</td>
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
    <x-slot name="scriptVendor">
        <script src="{{ asset('/assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    </x-slot>

    @slot('script')
    <script>

    </script>
    @endslot
</x-admin-layout>
