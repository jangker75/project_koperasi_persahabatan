<x-admin-layout titlePage="{{ $titlePage }}">
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-block d-md-flex justify-content-between">
                    <span class="card-title">Table untuk {{ $titlePage }}</span>
                    <div class="mt-4 mt-md-0">
                        <a href="{{ route('admin.product.edit', $product->id) }}">
                            <button class="btn btn-warning me-3" data-toggle="tooltip"
                            data-placement="top" title="Edit"><i class="fe fe-edit"></i></button>
                        </a>
                        <a href="#">
                            <button class="btn btn-info me-3" data-toggle="tooltip"
                            data-placement="top" title="Kelola Stock Produk"><i class="fe fe-clipboard"></i></button>
                        </a>
                        <a href="#">
                            <button class="btn btn-success me-3" data-toggle="tooltip"
                            data-placement="top" title="Kelola Harga Produk"><i class="fe fe-dollar-sign"></i></button>
                        </a>
                        <form action="{{ route('admin.product.destroy', $product->id) }}" class="d-inline"
                            method="post">
                            @csrf @method('delete')
                        </form>
                        <button type="submit" class="btn btn-danger delete-button me-1" data-toggle="tooltip"
                            data-placement="top" title="Hapus Produk"><i class="fe fe-trash-2"></i></button>
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
                <div class="card-header">
                    <div class="card-title">History Harga</div>
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product->price as $price)
                                <tr>
                                    <td>{{ format_uang($price->cost)  }}</td>
                                    <td>{{ format_uang($price->revenue)  }}</td>
                                    <td>{{ format_uang($price->profit)  }}</td>
                                    <td>{{ $price->margin }}%</td>
                                    <td>{{ $price->updated_at }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Kelola Stock Product</div>
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
                                    <td>--</td>
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
        

    </script>
    @endslot
</x-admin-layout>
