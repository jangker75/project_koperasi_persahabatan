<div class="row mb-4">
    {!! Form::label('interest_amount', __('loan.interest_amount'), ['class' => 'col-md-3 form-label required']) !!}
    <div class="col-md-2">
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
    <div class="col-md-7">
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
    </div>
</div>
<div class="row mb-4">
    <div class="col-md-3"></div>
    <div class="row col-md-3">
        <label>Percent Ratio Koperasi</label>
        <div class="input-group">
            <input name="profit_company_ratio" class="form-control" inputmode="numeric">
            <label class="input-group-text">%</label>
        </div>
    </div>
    <div class="row col-md-3">
        <label>Percent Ratio Nasabah</label>
        <div class="input-group">
            <input readonly name="profit_employee_ratio" class="form-control" inputmode="numeric">
            <label class="input-group-text">%</label>
        </div>
    </div>
    <div class="row col-md-3">
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
</div>
<div class="row">
    <div class="col-md-3">
        <label class="form-label">Informasi Pembayaran</label>
    </div>
    <div class="col-md-3">
        {!! Form::label('total_pay_month', __('loan.total_pay_month'), ['class' => 'form-label required']) !!}
        {!! Form::number('total_pay_month', 12, [
            'required' => 'required',
            'id' => 'total_pay_month',
            'class' =>
                'form-control' .
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
<div class="card mt-3">
    <input type="button" class="btn btn-primary" id="btn-simulate-loan" value="Simulasi Pinjaman">
    <div class="card-header">
        <h5>Table Simulasi Pinjaman</h5>
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
                        <th>Bunga</th>
                        <th>Total Cicilan</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
