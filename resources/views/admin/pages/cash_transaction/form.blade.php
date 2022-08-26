<x-admin-layout>
    @include('nasabah.shared.form_error')
    <a href="{{ $currentIndex }}" type="button" class="btn btn-danger mb-3">{{ __('general.button_cancel') }}</a>
    <div class="row">
        <div class="col-lg-12">
            @if (isset($cashTransaction))
                    {!! Form::model($cashTransaction, [
                        'route' => ['admin.cash-in-out.update', $cashTransaction],
                        'method' => 'PUT',
                        'files' => true,
                    ]) !!}
                    {!! Form::hidden('id') !!}
                @else
                    {!! Form::open(['route' => 'admin.cash-in-out.store', 'files' => true, 'class' => 'form-horizontal']) !!}
                @endif
                {{ Form::hidden('user_id', auth()->user()->id) }}
                
                @csrf
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $titlePage }}</h4>
                </div>
                <div class="card-body">

                    <div class="form-group">
                        {!! Form::label('transaction_type', __('cash_transaction.transaction_date'), ['class' => 'form-label']) !!}
                        {{ Form::text('transaction_date', null, [
                            'readonly'=> true,
                            'class'=> 'form-control',
                        ]) }}
                    </div>
                    <div class="form-group">
                        {!! Form::label('transaction_type', __('cash_transaction.transaction_type'), ['class' => 'form-label required']) !!}
                        {!! Form::select('transaction_type', \App\Enums\ConstantEnum::TRANSACTION_TYPE, null, [
                            'required' => 'required',
                            'class' =>
                                'form-control form-select select2' .
                                ($errors->has('transaction_type') ? ' is-invalid' : '') .
                                (!$errors->has('transaction_type') && old('transaction_type') ? ' is-valid' : ''),
                            'placeholder' => 'Input ' . __('cash_transaction.transaction_type'),
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('amount', __('cash_transaction.amount'), ['class' => 'form-label required']) !!}
                        {!! Form::text('amount', null, [
                            'placeholder' => 0,
                            'required' => 'required',
                            'class' => 'form-control',
                            'inputmode'=> 'numeric',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('description', __('cash_transaction.description'), ['class' => 'form-label']) !!}
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="icon icon-pencil"></i>
                                </div>
                                {!! Form::textarea('description', null, [
                                    'rows' => 4,
                                    'class' =>
                                        'form-control' .
                                        ($errors->has('description') ? ' is-invalid' : '') .
                                        (!$errors->has('description') && old('description') ? ' is-valid' : ''),
                                    'placeholder' => 'Input ' . __('cash_transaction.description'),
                                ]) !!}
                            </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success">{{ __('general.button_save') }}</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</x-admin-layout>