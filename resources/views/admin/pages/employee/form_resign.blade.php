<x-admin-layout>
    @include('nasabah.shared.form_error')
    <a href="{{ $currentIndex }}" type="button" class="btn btn-danger mb-3">{{ __('general.button_cancel') }}</a>
    <div class="row">
        <div class="col-lg-12">
            {!! Form::open(['route' => 'admin.employee.out.store', 'files' => true, 'class' => 'form-horizontal']) !!}
            @csrf
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $titlePage }}</h4>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        {!! Form::label('employee_id', __('employee.name'), ['class' => 'col-md-3 form-label required']) !!}
                        <div class="col-md-9">
                            {!! Form::select('employee_id', $employeeList, null, [
                                'required' => 'required',
                                'class' =>
                                    'form-control form-select select2' .
                                    ($errors->has('employee_id') ? ' is-invalid' : '') .
                                    (!$errors->has('employee_id') && old('employee_id') ? ' is-valid' : ''),
                                'placeholder' => 'Input ' . __('employee.name'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="row mb-4">
                        {!! Form::label('resign_date', __('employee.resign_date'), ['class' => 'col-md-3 form-label required']) !!}
                        <div class="col-md-9">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                </div>
                                {!! Form::text('resign_date', null, [
                                    'required' => 'required',
                                    'class' =>
                                        'form-control fc-datepicker' .
                                        ($errors->has('resign_date') ? ' is-invalid' : '') .
                                        (!$errors->has('resign_date') && old('resign_date') ? ' is-valid' : ''),
                                    'placeholder' => 'Input ' . __('employee.resign_date') . ' (YYYY-MM-DD)',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        {!! Form::label('resign_reason', __('employee.resign_reason'), ['class' => 'col-md-3 form-label required']) !!}
                        <div class="col-md-9">
                            {!! Form::select('resign_reason', \App\Enums\ConstantEnum::RESIGNREASON, null, [
                                'required' => 'required',
                                'class' =>
                                    'form-control form-select select2' .
                                    ($errors->has('resign_reason') ? ' is-invalid' : '') .
                                    (!$errors->has('resign_reason') && old('resign_reason') ? ' is-valid' : ''),
                                'placeholder' => 'Input ' . __('employee.resign_reason'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="row mb-4">
                        {!! Form::label('resign_notes', __('employee.resign_notes'), ['class' => 'col-md-3 form-label']) !!}
                        <div class="col-md-8">
                            {!! Form::textarea('resign_notes', null, [
                                'rows' => 4,
                                'class' =>
                                    'form-control' .
                                    ($errors->has('resign_notes') ? ' is-invalid' : '') .
                                    (!$errors->has('resign_notes') && old('resign_notes') ? ' is-valid' : ''),
                                'placeholder' => 'Input ' . __('employee.resign_notes'),
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a class="btn btn-danger" href="{{ $currentIndex }}">{{ __('general.button_cancel') }}</a>
                    <button class="btn btn-success">{{ __('general.button_save') }}</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    @slot('script')
        <script>
            $('.fc-datepicker').bootstrapdatepicker({
                todayHighlight: true,
                toggleActive: true,
                format: 'yyyy-mm-dd',
                autoclose: true,
            });
        </script>
    @endslot
</x-admin-layout>
