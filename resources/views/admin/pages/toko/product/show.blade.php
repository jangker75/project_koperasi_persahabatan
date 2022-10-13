<x-admin-layout titlePage="{{ $titlePage }}">
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-block d-md-flex justify-content-between">
                    <span class="card-title">Table untuk {{ $titlePage }}</span>
                    <div class="mt-4 mt-md-0">
                        <a href="{{ route('admin.product.edit', $product->id) }}">
                            <button class="btn btn-warning me-3" data-toggle="tooltip" data-placement="top"
                                title="Edit">Edit Data <i class="fe fe-edit"></i></button>
                        </a>
                        <form action="{{ route('admin.product.destroy', $product->id) }}" class="d-inline"
                            method="post">
                            @csrf @method('delete')
                        </form>
                        <button type="submit" class="btn btn-danger delete-button me-1" data-toggle="tooltip"
                            data-placement="top" title="Hapus Produk">Hapus Product <i
                                class="fe fe-trash-2"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="p-2 border">
                                <img src="{{ asset('storage/' . $product->cover) }}" alt="" class="w-100 img-thumbnail"
                                    style="height: 400px;object-fit: cover; overflow:hidden;">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-4">
                                <h1 class="h1 fw-bold">{{ $product->name }}</h1>
                                <h5 class="h5 text-secondary">#{{ $product->upc }}</h5>
                            </div>
                            <div class="mb-4">
                                <h4 class="h4 fw-bold">Deskripsi</h4>
                                <div>{!! $product->description !!}</div>
                            </div>
                            <div class="mb-4">
                                <h4 class="h4 fw-bold">Data Produk</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold">{{ __('product.name') }}</td>
                                                <td>{{ $product->name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">{{ __('product.sku') }}</td>
                                                <td>{{ $product->sku }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">{{ __('product.upc') }}</td>
                                                <td>{{ $product->upc }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">{{ __('product.unit_measurement') }}</td>
                                                <td>{{ $product->unit_measurement }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">{{ __('product.price') }}</td>
                                                <td>{{ format_uang($product->price[count($product->price) - 1]->revenue) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">{{ __('product.stock') }}</td>
                                                <td>{{ $product->stock[count($product->stock) - 1]->qty }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">{{ __('product.brand') }}</td>
                                                <td>
                                                    @if (isset($product->brand->name))
                                                    {{ $product->brand->name }}
                                                    @else
                                                    --
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-block d-md-flex justify-content-between">
                    <div class="card-title">Harga Produk</div>
                    <div class="mt-4 mt-md-0">
                        <a href="{{ route('admin.prices.from.product', $product->id) }}">
                            <button class="btn btn-warning me-3" data-toggle="tooltip" data-placement="top"
                                title="Edit">LIhat History Harga</button>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th>{{ __('price.cost') }}</th>
                                    <th>{{ __('price.revenue') }}</th>
                                    <th>{{ __('price.profit') }}</th>
                                    <th>{{ __('price.margin') }}</th>
                                    <th>Tanggal Update</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ format_uang($price->cost)  }}</td>
                                    <td>{{ format_uang($price->revenue)  }}</td>
                                    <td>{{ format_uang($price->profit)  }}</td>
                                    <td>{{ $price->margin }}%</td>
                                    <td>{{ $price->updated_at }}</td>
                                    <td>

                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                            data-bs-target="#modalNewPrice">
                                            Update Harga Terbaru
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="modalNewPrice" tabindex="-1"
                                            aria-labelledby="modalNewPriceLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalNewPriceLabel">Formulir Harga
                                                            Terbaru</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form
                                                            action="{{ route('admin.price.store', ['product_id' => $product->id]) }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <span class="input-group-text"
                                                                        id="basic-addon1">Rp</span>
                                                                    <input type="text"
                                                                        class="form-control format-uang cost"
                                                                        placeholder="Harga Modal" name="cost"
                                                                        id="cost2">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <span class="input-group-text"
                                                                        id="basic-addon1">%</span>
                                                                    <input type="text" class="form-control margin"
                                                                        placeholder="Margin" name="margin" id="margin2">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <span class="input-group-text"
                                                                        id="basic-addon1">Rp</span>
                                                                    <input type="text"
                                                                        class="form-control format-uang profit"
                                                                        placeholder="Keuntungan" name="profit"
                                                                        id="profit2">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <span class="input-group-text"
                                                                        id="basic-addon1">Rp</span>
                                                                    <input type="text"
                                                                        class="form-control format-uang revenue"
                                                                        placeholder="Harga Jual" name="revenue"
                                                                        id="revenue2" readonly>
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="btn btn-warning">Revisi
                                                                Harga</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Kelola Stok Produk</div>
                    <div class="card-options">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-info" data-bs-toggle="modal"
                            data-bs-target="#modalManualStock">
                            Edit Manual Data Stok Produk
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="modalManualStock" tabindex="-1" aria-labelledby="modalManualStockLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalManualStockLabel">Formulir Edit Manual Stok</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      <form action="{{ route('admin.update.manual.stock', $product->id) }}" method="POST" id="formManualStock">
                                        @csrf
                                        @foreach ($product->stock as $stock)
                                        <div class="form-group">
                                          <label for="{{ $stock->id }}">{{ $stock->store->name }}</label>
                                          <input type="number" name="stock[{{ $stock->id }}]" id="" value="{{ $stock->qty }}" class="form-control" placeholder="Masukan Jumlah Stok">
                                        </div>
                                        @endforeach
                                        <div class="btn btn-primary" id="btnSubmitManualStock">Submit</div>
                                      </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route("admin.history.stock.product", $product->id) }}" class="btn btn-info ms-2">Lihat History Stok</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th>Store</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal Update</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product->stock as $stock)
                                <tr>
                                    <td>{{ $stock->store->name }}</td>
                                    <td>{{ $stock->qty }}</td>
                                    <td>{{ $stock->updated_at }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @slot('script')
    <script>
        $(document).ready(function () {

            let cost = 0;
            let margin = 0;
            let profit = 0;
            let revenue = 0;
            let limit = parseInt("{{ $limitMargin }}")

            function changeValue(key, value){
              switch (key) {
                case "cost":
                  cost = value
                  profit = cost*margin/(100-margin);
                  break;
                case "margin":
                  margin = value
                  profit = cost*margin/(100-margin);
                  break;
                case "profit":
                  profit = value
                  if(profit*100/(cost+profit) < limit){
                    swal({
                        title: "Gagal",
                        text: "Harga harus memiliki minimal margin "+limit+"%",
                        type: "error"
                    });
                    return false;
                  }else{
                    margin = Math.ceil(profit*100/(cost+profit));
                  }
                  break;
              
                default:
                  break;
              }

                revenue = profit + cost;

                $("#cost2").val(formatRupiah(String(cost)));
                $("#margin2").val(formatRupiah(String(margin)));
                $("#profit2").val(formatRupiah(String(profit)));
                $("#revenue2").val(formatRupiah(String(revenue)));
            }

            $("#cost2").change(function () {
                let value = $(this).val();
                value = parseInt(value.replace('.', ''))
                changeValue('cost', value);
            })

            $("#profit2").change(function () {
                let value = $(this).val();
                value = parseInt(value.replace('.', ''))
                changeValue('profit', value);
            })

            $("#margin2").change(function () {
                let value = $(this).val();
                value = parseInt(value.replace('.', ''))
                if (value < limit) {
                    swal({
                        title: "Gagal",
                        text: "Harga harus memiliki minimal margin " + limit + "%",
                        type: "error"
                    });
                    $("#margin").val(formatRupiah(String(margin)));
                    return false;
                }
                changeValue('margin', value);
            })



            $("#btnSubmitManualStock").click(function(e){
              swal({
                title: "Anda yakin?",
                text: "Perubahan ini Akan mengubah stock secara Paksa",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: "Tidak, batalkan",
                closeOnConfirm: false,
                closeOnCancel: false
              }, function(isConfirm) {
                if (!isConfirm) {
                  e.preventDefault();
                  swal("Cancelled", "Dibatalkan", "error");
                  return false;
                }else{
                  $("#formManualStock").submit();
                }
              })
            })
        })

    </script>
    @endslot
</x-admin-layout>
