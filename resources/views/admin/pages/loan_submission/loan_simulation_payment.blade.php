<div class="row mb-4">
    {!! Form::label('interest_amount', __('Perhitungan Bunga'), ['class' => 'col-md-3 mb-2 form-label required']) !!}
    {{-- <div class="col-md-3 mb-2"></div> --}}
    <div class="col-md-3 mb-2">
        <label>{{ __('loan.interest_amount') }}</label>
        <div class="input-group">
            {!! Form::select('interest_amount_type', $interestTypeList, null, [
                'required' => 'required',
                'id' => 'interest_amount_type',
                'class' =>
                    'form-control form-select' .
                    ($errors->has('interest_amount_type') ? ' is-invalid' : '') .
                    (!$errors->has('interest_amount_type') && old('interest_amount_type') ? ' is-valid' : ''),
            ]) !!}
        </div>
    </div>
    <div class="col-md-3 mb-2">
        <label>Skema perhitungan Bunga</label>
        {!! Form::select('interest_scheme_type_id', $interestSchemeList, 2, [
                'required' => 'required',
                'id' => 'interest_scheme',
                'class' =>
                    'form-control form-select' .
                    ($errors->has('interest_scheme_type_id') ? ' is-invalid' : '') .
                    (!$errors->has('interest_scheme_type_id') && old('interest_scheme_type_id') ? ' is-valid' : ''),
            ]) !!}
    </div>
    <div class="col-md-3 mb-2"></div>
    <div class="col-md-3 mb-2"></div>
    <div class="col-md-3 mb-2">
            {!! Form::text('interest_amount', 2, [
                'required' => 'required',
                'id' => 'interest_amount',
                'inputmode'=> 'numeric',
                'class' =>
                    'form-control' .
                    ($errors->has('interest_amount') ? ' is-invalid' : '') .
                    (!$errors->has('interest_amount') && old('interest_amount') ? ' is-valid' : ''),
                'placeholder' => 'Input ' . __('loan.interest_amount'),
            ]) !!}
            <small>* Bunga Bulanan</small>
    </div>
    <div class="col-md-3 mb-2">
            {!! Form::text('interest_amount_yearly', 0, [
                'required' => 'required',
                'id' => 'interest_amount_yearly',
                'inputmode'=> 'numeric',
                'readonly' => true,
                'class' =>
                    'form-control' .
                    ($errors->has('interest_amount_yearly') ? ' is-invalid' : '') .
                    (!$errors->has('interest_amount_yearly') && old('interest_amount_yearly') ? ' is-valid' : ''),
                'placeholder' => 'Input ' . __('loan.interest_amount_yearly'),
            ]) !!}
            <small>* Suku Bunga per Tahun</small>
    </div>
</div>
<div class="row mb-4">
    <div class="col-md-3"></div>
    <div class="col-md-3">
        <label>Percent Ratio Koperasi</label>
        <div class="input-group">
            <input name="profit_company_ratio" class="form-control" id="profit_company_ratio" inputmode="numeric">
            <label class="input-group-text">%</label>
        </div>
    </div>
    <div class="col-md-3">
        <label>Percent Ratio Nasabah</label>
        <div class="input-group">
            <input readonly name="profit_employee_ratio" id="profit_employee_ratio" class="form-control" inputmode="numeric">
            <label class="input-group-text">%</label>
        </div>
    </div>
    
</div>
<div class="row mb-4">
    <div class="col-md-3">
        <label class="form-label">Informasi Pembayaran</label>
    </div>
    <div class="col-md-3" id="tenor_bulanan">
        {!! Form::label('total_pay_month', __('loan.total_pay_month'), ['class' => 'form-label required']) !!}
        {!! Form::select('total_pay_month', [5 => 5,10 => 10,15 => 15,20 => 20,30 => 30], null, [
                'required' => 'required',
                'id' => 'total_pay_month',
                'class' =>
                    'form-control form-select' .
                    ($errors->has('total_pay_month') ? ' is-invalid' : '') .
                    (!$errors->has('total_pay_month') && old('total_pay_month') ? ' is-valid' : ''),
        ]) !!}
    </div>
    <div class="col-md-3">
        {!! Form::label('pay_per_x_month', __('loan.pay_per_x_month'), ['class' => 'form-label required']) !!}
        <div class="input-group">
            {!! Form::number('pay_per_x_month', 1, [
                'required' => 'required',
                'id' => 'pay_per_x_month',
                'class' =>
                    'form-control' .
                    ($errors->has('pay_per_x_month') ? ' is-invalid' : '') .
                    (!$errors->has('pay_per_x_month') && old('pay_per_x_month') ? ' is-valid' : ''),
                'placeholder' => 'Input ' . __('loan.pay_per_x_month'),
            ]) !!}
            <label class="input-group-text">bulan</label>
        </div>
    </div>
</div>
<div class="row mb-4">
    {!! Form::label('total_loan_amount', __('loan.total_loan_amount'), ['class' => 'col-md-3 form-label required']) !!}
    <div class="col-md-9">
        <div class="input-group">
        <label class="input-group-text">Rp.</label>
        {!! Form::text('total_loan_amount', null, [
            'id' => 'total_loan_amount',
            'required' => 'required',
            'inputmode'=> 'numeric',
            'class' =>
                'form-control' .
                ($errors->has('total_loan_amount') ? ' is-invalid' : '') .
                (!$errors->has('total_loan_amount') && old('total_loan_amount') ? ' is-valid' : ''),
            'placeholder' => 'Input ' . __('loan.total_loan_amount'),
        ]) !!}
        </div>
    </div>
</div>
<div class="row mb-4">
    {!! Form::label('admin_fee', __('loan.admin_fee'), ['class' => 'col-md-3 form-label required']) !!}
    <div class="col-md-2">
        <div class="input-group">
            <input class="form-control" type="text" id="admin_fee_percentage" min="0" max="100">
            <label class="input-group-text">%</label>
        </div>
    </div>
    <div class="col-md-7">
        <div class="input-group">
            <label class="input-group-text">Rp.</label>
        {!! Form::text('admin_fee', null, [
            // 'required' => 'required',
            'id' => 'admin_fee',
            'inputmode'=> 'numeric',
            'class' =>
                'form-control' .
                ($errors->has('admin_fee') ? ' is-invalid' : '') .
                (!$errors->has('admin_fee') && old('admin_fee') ? ' is-valid' : ''),
            'placeholder' => 'Input ' . __('loan.admin_fee'),
        ]) !!}
        </div>
    </div>
</div>
<div class="row mb-4">
    {!! Form::label('received_amount', __('loan.received_amount'), ['class' => 'col-md-3 form-label required']) !!}
    <div class="col-md-9">
        <div class="input-group">
            <label class="input-group-text">Rp.</label>
            {!! Form::text('received_amount', null, [
            'readonly' => true,
            'id' => 'received_amount',
            'required' => 'required',
            'class' =>
                'form-control' .
                ($errors->has('received_amount') ? ' is-invalid' : '') .
                (!$errors->has('received_amount') && old('received_amount') ? ' is-valid' : ''),
            'placeholder' => 'Input ' . __('loan.received_amount'),
        ]) !!}
        </div>
    </div>
</div>

<div class="row mb-4">
    {!! Form::label('notes', __('loan.notes'), ['class' => 'col-md-3 form-label']) !!}
    <div class="col-md-9">
        <div class="input-group">
            <div class="input-group-text">
                <i class="icon icon-pencil"></i>
            </div>
            {!! Form::textarea('notes', null, [
                'rows' => 4,
                'class' =>
                    'form-control' .
                    ($errors->has('notes') ? ' is-invalid' : '') .
                    (!$errors->has('notes') && old('notes') ? ' is-valid' : ''),
                'placeholder' => 'Input ' . __('loan.notes'),
            ]) !!}
        </div>
    </div>
</div>
<div class="card mt-3">
    <input type="button" class="btn btn-primary" id="btn-simulate-loan" value="Simulasi Pinjaman">
    <div class="card-header">
        <h5>Table Simulasi Pinjaman</h5>
    </div>
    <div class="row">
        <div class="d-flex justify-content-end">
            <button id="btnDownloadSimulation" type="submit" class="btn btn-success btn-sm"><b>Download Tabel Simulasi</b></button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-nowrap border-bottom" id="table-simulation">
                <thead>
                    <tr>
                        <th>Cicilan-ke #</th>
                        <th>Tgl Tagih</th>
                        <th>Saldo Hutang</th>
                        <th>Pokok</th>
                        {{-- <th>Bunga</th> --}}
                        <th>Margin KOP</th>
                        <th>Simpanan Khusus</th>
                        <th>Total Cicilan</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
