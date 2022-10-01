<x-admin-layout titlePage="{{ $titlePage }}">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div>
                
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Opname</div>
                    <div class="card-options">
                        @if ($opname->is_commit == false)
                        <a href="" class="btn btn-sm mx-1 btn-primary">Commit Opname</a>
                        <a href="" class="btn btn-sm mx-1 btn-warning">Edit Opname</a>
                        <a href="" class="btn btn-sm mx-1 btn-danger">Hapus Opname</a>
                        @endif
                        <a href="" class="btn btn-sm mx-1 btn-info">Print Opname</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="w-100 mb-4">
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
        {{-- <!-- Modal -->
        <div class="modal fade" id="modalConfirmStock" tabindex="-1" aria-labelledby="modalConfirmStockLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content w-100" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalConfirmStockLabel">Konfirmasi Ketersediaan Stock</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                          @if ($transferStock->Status->name == "Ordering")
                          <table class="table table-bordered">
                            <thead class="table-success fw-bold text-uppercase">
                              <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Stok Tersedia</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($availableStock as $j => $item)
                              <tr>
                                <td>{{ $j+1 }}</td>
                                <td>{{ $item->productName }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->stock }}</td>
                                <td>
                                  <input type="number" class="form-control input-available @if ($item->quantity > $item->stock)
                                    is-invalid
                                  @endif" placeholder="masukan jumlah yang akan dikirim"
                                    data-id="{{ $item->id }}" data-stock="{{ $item->stock }}" value="{{ $item->quantity }}">
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                          @endif
                          @if ($transferStock->Status->name == "Processing")
                            <table class="table table-bordered">
                            <thead class="table-success fw-bold text-uppercase">
                              <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Jumlah yang dikirim</th>
                                <th>Jumlah diterima</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($transferStock->detailItem as $j => $item)
                              <tr>
                                <td>{{ $j+1 }}</td>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->available_qty }}</td>
                                <td>
                                  <input type="number" class="form-control input-available" placeholder="masukan jumlah yang akan dikirim"
                                    data-id="{{ $item->id }}" data-stock="{{ $item->available_qty }}" value="{{ $item->available_qty }}">
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                          @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        @if ($transferStock->Status->name == "Ordering")
                        <button type="button" class="btn btn-primary" id="submitAvailable">Konfirmasi Ketersediaan</button>
                        @endif
                        @if ($transferStock->Status->name == "Processing")
                        <button type="button" class="btn btn-primary" id="submitReceive">Konfirmasi Ketersediaan</button>
                        @endif
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

    <x-slot name="style">
        
    </x-slot>

    <x-slot name="scriptVendor">
        <script src="{{ asset('/assets/plugins/fileuploads/js/fileupload.js') }}"></script>
        <script src="{{ asset('../assets/plugins/select2/select2.full.min.js') }}"></script>
    </x-slot>

    @slot('script')
    <script>

    </script>
    @endslot
</x-admin-layout>
