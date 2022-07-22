<x-admin-layout>
    @include('nasabah.shared.form_error')
    <div class="row">
        <div class="col-lg-12">
            @if (isset($employee))
                    {!! Form::model($employee, [
                        'route' => ['admin.employee.update', $employee],
                        'method' => 'PUT',
                        'files' => true,
                    ]) !!}
                    {!! Form::hidden('id') !!}
                @else
                    {!! Form::open(['route' => 'admin.employee.store', 'files' => true, 'class' => 'form-horizontal']) !!}
                @endif
                @csrf
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $titlePage }}</h4>
                </div>
                
                <div class="card-body">
                    <div class="row mb-4">
                        {!! Form::label('first_name', __('employee.first_name'), ['class' => 'col-md-3 form-label required']) !!}
                        <div class="col-md-3">
                            {!! Form::text('first_name', null, [
                                'required' => 'required',
                                'class' =>
                                    'form-control' .
                                    ($errors->has('first_name') ? ' is-invalid' : '') .
                                    (!$errors->has('first_name') && old('first_name') ? ' is-valid' : ''),
                                'placeholder' => 'Input ' . __('employee.first_name'),
                            ]) !!}
                        </div>
                        {!! Form::label('last_name', __('employee.last_name'), ['class' => 'col-md-2 form-label required']) !!}
                        <div class="col-md-4">
                            {!! Form::text('last_name', null, [
                                'required' => 'required',
                                'class' =>
                                    'form-control' .
                                    ($errors->has('last_name') ? ' is-invalid' : '') .
                                    (!$errors->has('last_name') && old('last_name') ? ' is-valid' : ''),
                                'placeholder' => 'Input ' . __('employee.last_name'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="row mb-4">
                        {!! Form::label('nik', __('employee.nik'), ['class' => 'col-md-3 form-label required']) !!}
                        <div class="col-md-9">
                            {!! Form::text('nik', null, [
                                'required' => 'required',
                                'class' =>
                                    'form-control' .
                                    ($errors->has('nik') ? ' is-invalid' : '') .
                                    (!$errors->has('nik') && old('nik') ? ' is-valid' : ''),
                                'placeholder' => 'Input ' . __('employee.nik'),
                            ]) !!}
                        </div>
                    </div>

                    <div class="row mb-4">
                        {!! Form::label('nip', __('employee.nip'), ['class' => 'col-md-3 form-label']) !!}
                        <div class="col-md-9">
                            {!! Form::text('nip', null, [
                                'class' =>
                                    'form-control' .
                                    ($errors->has('nip') ? ' is-invalid' : '') .
                                    (!$errors->has('nip') && old('nip') ? ' is-valid' : ''),
                                'placeholder' => 'Input ' . __('employee.nip'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="row mb-4">
                        {!! Form::label('gender', __('employee.gender'), ['class' => 'col-md-3 form-label required']) !!}
                        <div class="col-md-9">
                            {!! Form::select('gender', \App\Enums\ConstantEnum::GENDER, null, [
                                'required' => 'required',
                                'class' =>
                                    'form-control form-select' .
                                    ($errors->has('gender') ? ' is-invalid' : '') .
                                    (!$errors->has('gender') && old('gender') ? ' is-valid' : ''),
                                'placeholder' => 'Input ' . __('employee.gender'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="row mb-4">
                        {!! Form::label('position_id', __('employee.position_id'), ['class' => 'col-md-3 form-label']) !!}
                        <div class="col-md-9">
                            {!! Form::select('position_id', $positionList, null, [
                                'class' =>
                                    'form-control form-select' .
                                    ($errors->has('position_id') ? ' is-invalid' : '') .
                                    (!$errors->has('position_id') && old('position_id') ? ' is-valid' : ''),
                                'placeholder' => 'Input ' . __('employee.position_id'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="row mb-4">
                        {!! Form::label('status_employee_id', __('employee.status_employee_id'), ['class' => 'col-md-3 form-label required']) !!}
                        <div class="col-md-9">
                            {!! Form::select('status_employee_id', $statusEmployeeList, null, [
                                'required' => 'required',
                                'class' =>
                                    'form-control form-select' .
                                    ($errors->has('status_employee_id') ? ' is-invalid' : '') .
                                    (!$errors->has('status_employee_id') && old('status_employee_id') ? ' is-valid' : ''),
                                'placeholder' => 'Input ' . __('employee.status_employee_id'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="row mb-4">
                        {!! Form::label('salary', __('employee.salary'), ['class' => 'col-md-3 form-label required']) !!}
                        <div class="col-md-9">
                            {!! Form::number('salary', null, [
                                'required' => 'required',
                                'class' =>
                                    'form-control' .
                                    ($errors->has('salary') ? ' is-invalid' : '') .
                                    (!$errors->has('salary') && old('salary') ? ' is-valid' : ''),
                                'placeholder' => 'Input ' . __('employee.salary'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="row mb-4">
                        {!! Form::label('birthday', __('employee.birthday'), ['class' => 'col-md-3 form-label required']) !!}
                        <div class="col-md-9">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                </div>
                                {!! Form::text('birthday', null, [
                                    'required' => 'required',
                                    'class' =>
                                        'form-control fc-datepicker' .
                                        ($errors->has('birthday') ? ' is-invalid' : '') .
                                        (!$errors->has('birthday') && old('birthday') ? ' is-valid' : ''),
                                    'placeholder' => 'Input ' . __('employee.birthday') . ' (YYYY-MM-DD)',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        {!! Form::label('address1', __('employee.address1'), ['class' => 'col-md-3 form-label']) !!}
                        <div class="col-md-9">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="icon icon-map"></i>
                                </div>
                                {!! Form::textarea('address1', null, [
                                    'rows' => 4,
                                    'class' =>
                                        'form-control' .
                                        ($errors->has('address1') ? ' is-invalid' : '') .
                                        (!$errors->has('address1') && old('address1') ? ' is-valid' : ''),
                                    'placeholder' => 'Input ' . __('employee.address1'),
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        {!! Form::label('address2', __('employee.address2'), ['class' => 'col-md-3 form-label']) !!}
                        <div class="col-md-9">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="icon icon-map"></i>
                                </div>
                                {!! Form::textarea('address2', null, [
                                    'rows' => 4,
                                    'class' =>
                                        'form-control' .
                                        ($errors->has('address2') ? ' is-invalid' : '') .
                                        (!$errors->has('address2') && old('address2') ? ' is-valid' : ''),
                                    'placeholder' => 'Input ' . __('employee.address2'),
                                ]) !!}
                            </div>
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
