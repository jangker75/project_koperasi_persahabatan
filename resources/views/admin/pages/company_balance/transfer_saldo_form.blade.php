<x-admin-layout>
    @include('nasabah.shared.form_error')
    <a href="{{ $currentIndex }}" type="button" class="btn btn-danger mb-3">{{ __('general.button_cancel') }}</a>
    <div class="row">
        <div class="card">
            {!! Form::open(['route' => 'admin.company-balance.store', 'files' => true, 'class' => 'form-horizontal']) !!}
            @csrf
            <div class="card-header">
                <h4 class="card-title">{{ $titlePage }}</h4>
            </div>
            
            <div class="card-body">
                <div class="row mb-4">
                    {!! Form::label('source_balance', __('balance_company.source_balance'), ['class' => 'col-md-3 form-label required']) !!}
                    <div class="col-md-3">
                        {!! Form::select('source_balance', \App\Enums\ConstantEnum::BALANCE_COMPANY, null, [
                            'required' => 'required',
                            'class' =>
                                'form-control form-select' .
                                ($errors->has('source_balance') ? ' is-invalid' : '') .
                                (!$errors->has('source_balance') && old('source_balance') ? ' is-valid' : ''),
                            'placeholder' => 'Input ' . __('balance_company.source_balance'),
                        ]) !!}
                    </div>
                </div>
                <div class="row mb-4">
                    {!! Form::label('destination_balance', __('balance_company.destination_balance'), ['class' => 'col-md-3 form-label required']) !!}
                    <div class="col-md-3">
                        {!! Form::select('destination_balance', \App\Enums\ConstantEnum::BALANCE_COMPANY, null, [
                            'required' => 'required',
                            'class' =>
                                'form-control form-select' .
                                ($errors->has('destination_balance') ? ' is-invalid' : '') .
                                (!$errors->has('destination_balance') && old('destination_balance') ? ' is-valid' : ''),
                            'placeholder' => 'Input ' . __('balance_company.destination_balance'),
                        ]) !!}
                    </div>
                </div>
                <div class="row mb-4">
                    {!! Form::label('amount', __('balance_company.amount'), ['class' => 'col-md-3 form-label required']) !!}
                    <div class="col-md-3">
                        {!! Form::text('amount', null, [
                            'required' => 'required',
                            'class' =>
                                'form-control' .
                                ($errors->has('amount') ? ' is-invalid' : '') .
                                (!$errors->has('amount') && old('amount') ? ' is-valid' : ''),
                            'placeholder' => 'Input ' . __('balance_company.amount'),
                        ]) !!}
                    </div>
                </div>
                <div class="row mb-4">
                    {!! Form::label('description', __('balance_company.description'), ['class' => 'col-md-3 form-label']) !!}
                    <div class="col-md-3">
                        {!! Form::textarea('description', null, [
                                    'rows' => 4,
                                    'class' =>
                                        'form-control' .
                                        ($errors->has('description') ? ' is-invalid' : '') .
                                        (!$errors->has('description') && old('description') ? ' is-valid' : ''),
                                    'placeholder' => 'Input ' . __('balance_company.description'),
                                ]) !!}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a class="btn btn-danger" href="{{ $currentIndex }}">{{ __('general.button_cancel') }}</a>
                <button class="btn btn-success">{{ __('general.button_save') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</x-admin-layout>