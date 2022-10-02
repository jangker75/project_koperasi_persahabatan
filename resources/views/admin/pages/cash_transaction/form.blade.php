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
                        {!! Form::label('transaction_date', __('cash_transaction.transaction_date'), ['class' => 'form-label']) !!}
                        {{-- {{ Form::text('transaction_date', null, [
                            'readonly'=> true,
                            'class'=> 'form-control',
                        ]) }} --}}
                        {!! Form::text('transaction_date', now()->format('d-m-Y H:i'), [
                            'readonly' => true,
                            'id' => 'transaction_date',
                            'class' => 'form-control'.
                                ($errors->has('transaction_date') ? ' is-invalid' : '') .
                                (!$errors->has('transaction_date') && old('transaction_date') ? ' is-valid' : ''),
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('transaction_type', __('cash_transaction.transaction_type'), ['class' => 'form-label required']) !!}
                        {!! Form::select('transaction_type', \App\Enums\ConstantEnum::TRANSACTION_TYPE_DIV_UMUM, null, [
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
    @slot('style')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    @endslot
    @slot('script')
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.id.js') }}"></script>
    <script>
        $(function () {
            $('#transaction_date').datetimepicker({
                initialDate: new moment(),
                autoclose: true,
                todayHighlight: true,
                format:'dd-mm-yyyy hh:ii',
                weekStart: 1,
                todayBtn: true,
            });
        });

        
    </script>
    @endslot
</x-admin-layout>