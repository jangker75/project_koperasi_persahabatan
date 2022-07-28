<x-admin-layout titlePage="{{ $titlePage }}">
    @include('nasabah.shared.form_error')
    <a href="{{ $currentIndex }}" type="button" class="btn btn-danger mb-5">Batal Buat Produk Baru</a>

    <div class="row">
        <div class="col-lg-12">
            @if (isset($product))
            {!! Form::model($product, [
            'route' => ['admin.product.update', $product],
            'method' => 'PUT',
            'files' => true,
            ]) !!}
            {!! Form::hidden('id') !!}
            @else
            {!! Form::open(['route' => 'admin.product.store', 'files' => true, 'class' => 'form-horizontal']) !!}
            @endif
            @csrf
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Kredensi Produk</div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        {!! Form::label('name', __('product.name'), ['class' => 'col-md-2 form-label required']) !!}
                        <div class="col-md-10">
                            {!! Form::text('name', null, [
                            'required' => 'required',
                            'class' =>
                            'form-control' .
                            ($errors->has('name') ? ' is-invalid' : '') .
                            (!$errors->has('name') && old('name') ? ' is-valid' : ''),
                            'placeholder' => 'Input ' . __('product.name'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="row mb-4">
                        {!! Form::label('sku', __('product.sku'), ['class' => 'col-md-2 form-label required']) !!}
                        <div class="col-md-4">
                            {!! Form::text('sku', null, [
                            'required' => 'required',
                            'class' =>
                            'form-control' .
                            ($errors->has('sku') ? ' is-invalid' : '') .
                            (!$errors->has('sku') && old('sku') ? ' is-valid' : ''),
                            'placeholder' => 'Input ' . __('product.sku'),
                            ]) !!}
                        </div>
                        {!! Form::label('upc', __('product.upc'), ['class' => 'col-md-1 form-label required']) !!}
                        <div class="col-md-5">
                            {!! Form::text('upc', null, [
                            'required' => 'required',
                            'class' =>
                            'form-control' .
                            ($errors->has('upc') ? ' is-invalid' : '') .
                            (!$errors->has('upc') && old('upc') ? ' is-valid' : ''),
                            'placeholder' => 'Input ' . __('product.upc'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="row mb-4">
                        {!! Form::label('description', __('product.description'), ['class' => 'col-md-2 form-label
                        required']) !!}
                        <div class="col-md-10">
                            {!! Form::textarea('description', null, [
                            'class' =>
                            'form-control' .
                            ($errors->has('description') ? ' is-invalid' : '') .
                            (!$errors->has('description') && old('description') ? ' is-valid' : ''),
                            'rows' => 4,
                            'name' => 'description',
                            'id' => 'description',
                            'placeholder' => 'Input ' . __('product.description'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="row mb-4">
                        {!! Form::label('unit_measurement', __('product.unit_measurement'), ['class' => 'col-md-2
                        form-label
                        required']) !!}
                        <div class="col-md-4">
                            {!! Form::text('unit_measurement', null, [
                            'required' => 'required',
                            'class' =>
                            'form-control' .
                            ($errors->has('unit_measurement') ? ' is-invalid' : '') .
                            (!$errors->has('unit_measurement') && old('unit_measurement') ? ' is-valid' : ''),
                            'placeholder' => 'Input ' . __('product.unit_measurement'),
                            ]) !!}
                        </div>
                        {!! Form::label('brand_id', __('product.brand'), ['class' => 'col-md-1 form-label required'])
                        !!}
                        <div class="col-md-4">
                            {!! Form::select('brand_id', $brand, isset($product) ? $product->brand_id : null, [
                            'class' =>
                            'form-control form-select brand-input' .
                            ($errors->has('brand_id') ? ' is-invalid' : '') .
                            (!$errors->has('brand_id') && old('brand_id') ? ' is-valid' : ''),
                            'placeholder' => 'Pilih ' . __('product.brand'),
                            ]) !!}
                            {!! Form::text('new_brand', null, [
                            'class' =>
                            'form-control brand-input d-none' .
                            ($errors->has('new_brand') ? ' is-invalid' : '') .
                            (!$errors->has('new_brand') && old('new_brand') ? ' is-valid' : ''),
                            'placeholder' => 'Input ' . __('product.brand') . ' Baru',
                            ]) !!}
                        </div>
                        <div class="col-md-1">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="newBrand">
                                <label class="form-check-label" for="newBrand">
                                    Brand Baru
                                </label>
                            </div>

                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="form-label col-md-2">Pilih Category</label>
                        <div class="col-md-10">
                            <input type="hidden" name="ProductCategory" id="ProductCategory" value="{{ isset($product['categories']) ? $product['categories'] : '' }}">
                            <select class="form-control select2" id="categories" name="categories[]" data-placeholder="Pilih Category" multiple>
                                @foreach ($categories as $id => $cat)
                                <option value="{{ $id }}" >
                                    {{ $cat }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="form-label col-md-2">Gambar Cover</label>
                        <div class="col-md-10">
                            <input type="file"  class="dropify" name="cover" data-bs-height="180" data-max-file-size="2M" />
                        </div>
                    </div>
                </div>
            </div>
            @if (!isset($product))
              
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Kelola Data Supplier</div>
                </div>
                <div class="card-body">
                    <div class="panel panel-primary">
                        <div class="tab-menu-heading">
                            <div class="tabs-menu">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs">
                                    <li><a href="#tab1" class="active" data-bs-toggle="tab">Daftarkan ke Supplier yang
                                            ada</a></li>
                                    <li><a href="#tab2" data-bs-toggle="tab">Menambah Supplier Baru</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="datatable">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" value="" id="allSupplier"></th>
                                                    <th>Name</th>
                                                    <th>Kode Supplier</th>
                                                    <th>Nama Kontak</th>
                                                    <th>Nomor Kontak</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($suppliers as $supplier)
                                                <tr>
                                                    <td><input type="checkbox" class="check-supplier"
                                                            value="{{ $supplier->id }}"
                                                            name="supplier[]"></td>
                                                    <td>{{ $supplier->name }}</td>
                                                    <td>{{ $supplier->supplier_code }}</td>
                                                    <td>{{ $supplier->contact_name }}</td>
                                                    <td>{{ $supplier->contact_phone }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab2">
                                    <div class="row mb-4">
                                        {!! Form::label('supplierName', __('supplier.name'), ['class' => 'col-md-2
                                        form-label
                                        required']) !!}
                                        <div class="col-md-4">
                                            {!! Form::text('new_supplier[name]', null, [
                                            'class' =>
                                            'form-control' .
                                            ($errors->has('name') ? ' is-invalid' : '') .
                                            (!$errors->has('name') && old('name') ? ' is-valid' : ''),
                                            'placeholder' => 'Input ' . __('supplier.name'),
                                            ]) !!}
                                        </div>
                                        {!! Form::label('contact_name', __('supplier.contact_name'), ['class' =>
                                        'col-md-2 form-label
                                        required']) !!}
                                        <div class="col-md-4">
                                            {!! Form::text('new_supplier[contact_name]', null, [
                                            'class' =>
                                            'form-control' .
                                            ($errors->has('contact_name') ? ' is-invalid' : '') .
                                            (!$errors->has('contact_name') && old('contact_name') ? ' is-valid' : ''),
                                            'placeholder' => 'Input ' . __('supplier.contact_name'),
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        {!! Form::label('contact_address', __('supplier.contact_address'), ['class' =>
                                        'col-md-2 form-label
                                        required']) !!}
                                        <div class="col-md-4">
                                            {!! Form::text('new_supplier[contact_address]', null, [
                                            'class' =>
                                            'form-control' .
                                            ($errors->has('contact_address') ? ' is-invalid' : '') .
                                            (!$errors->has('contact_address') && old('contact_address') ? ' is-valid' :
                                            ''),
                                            'placeholder' => 'Input ' . __('supplier.contact_address'),
                                            ]) !!}
                                        </div>
                                        {!! Form::label('contact_phone', __('supplier.contact_phone'), ['class' =>
                                        'col-md-2 form-label
                                        required']) !!}
                                        <div class="col-md-4">
                                            {!! Form::text('new_supplier[contact_phone]', null, [
                                            'class' =>
                                            'form-control' .
                                            ($errors->has('contact_phone') ? ' is-invalid' : '') .
                                            (!$errors->has('contact_phone') && old('contact_phone') ? ' is-valid' : ''),
                                            'placeholder' => 'Input ' . __('supplier.contact_phone'),
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        {!! Form::label('contact_link', __('supplier.contact_link'), ['class' =>
                                        'col-md-2 form-label
                                        required']) !!}
                                        <div class="col-md-4">
                                            {!! Form::text('new_supplier[contact_link]', "--", [
                                            'class' =>
                                            'form-control' .
                                            ($errors->has('contact_link') ? ' is-invalid' : '') .
                                            (!$errors->has('contact_link') && old('contact_link') ? ' is-valid' : ''),
                                            'placeholder' => 'Input ' . __('supplier.contact_link'),
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Kelola Harga Produk</div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            {!! Form::label('priceCost', __('price.cost'), ['class' => 'form-label
                            required']) !!}
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                {!! Form::text('price[cost]', null, [
                                'id' => 'cost',
                                'class' =>
                                'form-control format-uang' .
                                ($errors->has('cost') ? ' is-invalid' : '') .
                                (!$errors->has('cost') && old('cost') ? ' is-valid' : ''),
                                'placeholder' => 'Input ' . __('price.cost'),
                                ]) !!}
                            </div>
                            
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('revenue', __('price.revenue'), ['class' => 'form-label
                            required']) !!}
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                {!! Form::text('price[revenue]', null, [
                                'id' => 'revenue',
                                'class' =>
                                'form-control format-uang' .
                                ($errors->has('revenue') ? ' is-invalid' : '') .
                                (!$errors->has('revenue') && old('revenue') ? ' is-valid' : ''),
                                'placeholder' => 'Input ' . __('price.revenue'),
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('profit', __('price.profit'), ['class' => 'form-label
                            required']) !!}
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                {!! Form::text('price[profit]', null, [
                                'id' => 'profitPrice',
                                'class' =>
                                'form-control format-uang' .
                                ($errors->has('profit') ? ' is-invalid' : '') .
                                (!$errors->has('profit') && old('profit') ? ' is-valid' : ''),
                                'placeholder' => 'Input ' . __('price.profit'),
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('margin', __('price.margin'), ['class' => 'form-label
                            required']) !!}
                            <div class="input-group">
                                
                                {!! Form::text('price[margin]', null, [
                                'id' => 'margin',
                                'class' =>
                                'form-control format-uang' .
                                ($errors->has('margin') ? ' is-invalid' : '') .
                                (!$errors->has('margin') && old('margin') ? ' is-valid' : ''),
                                'placeholder' => 'Input ' . __('price.margin'),
                                ]) !!}
                                <span class="input-group-text" id="basic-addon1">%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="mb-4">
              <a class="btn btn-danger" href="{{ $currentIndex }}">{{ __('general.button_cancel') }}</a>
              <button type="submit" class="btn btn-success">{{ __('general.button_save') }}</button>
            </div>
            {!! Form::close() !!}
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
            // valueDefault
            if($('#ProductCategory').val() !== null){
              let categories = $("#categories").select2();
              let valueCategory = String($('#ProductCategory').val())
              valueCategory = valueCategory.split(',');
              categories.val(valueCategory).change();
            }

            // new brand
            $("#newBrand").change(function () {
                if ($(this).is(':checked')) {
                    $('select.brand-input').toggleClass('d-none')
                    $('input.brand-input').toggleClass('d-none')
                } else {
                    $('select.brand-input').toggleClass('d-none')
                    $('input.brand-input').toggleClass('d-none')
                }
            })

            // datatable supplier
            let datatable = $("#datatable").DataTable();
            $("#allSupplier").change(function () {
                if ($(this).is(':checked')) {
                    $('input.check-supplier').prop('checked', true);
                } else {
                    $('input.check-supplier').prop('checked', false);
                }
            })
            // datatable supplier

            // for description
            tinymce.init({
                selector: 'textarea#description',
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

            //calculate margin & profit
            $('#revenue').keyup(function () {
                let cost = $('#cost').val();
                cost = parseInt(cost.replace('.', ''))
                let revenue = $('#revenue').val()
                revenue = parseInt(revenue.replace('.', ''));

                let profit = revenue - cost;
                let margin = profit * 100 / revenue;

                $('#margin').val(margin)
                $('#profitPrice').val(formatRupiah(String(profit)))
            })

            $('#categories')

        })
        $('.fc-datepicker').bootstrapdatepicker({
            todayHighlight: true,
            toggleActive: true,
            format: 'yyyy-mm-dd',
            autoclose: true,
        });

    </script>
    @endslot
</x-admin-layout>
