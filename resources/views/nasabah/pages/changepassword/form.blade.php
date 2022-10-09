<section class="py-4 bg-white">
    <div class="d-flex align-items-center">
        <a href="{{ url()->previous() }}" class="btn fw-bold h5 m-0">
            <i class="fa fa-angle-left text-muted"></i>
        </a>
        
        <h1 class="h3 fw-bold m-0">Change Password</h1>
    </div>
</section>
{{-- {{ dd($errors->all()) }} --}}
<section class="col-12">
    <div class="row">
        <div class="col-lg-12">
                {!! Form::open([
                    'route' => ['nasabah.profile.changepassword'],
                    'method' => 'POST',
                    'files' => true,
                ]) !!}
                @csrf
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Change Password</h4>
                </div>
                @include('nasabah.shared.form_error')
                <div class="card-body bg-blue-1">
                    <div class="form-group row mb-4">
                        {!! Form::label('old_password', __('employee.old_password'), ['class' => 'form-label required']) !!}
                        <div class="col-12">
                            {!! Form::password('old_password', [
                                'required' => 'required',
                                'class' =>
                                    'form-control',
                                'placeholder' => 'Input ' . __('employee.old_password'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        {!! Form::label('password', __('employee.password'), ['class' => 'form-label required']) !!}
                        <div class="col-12">
                            {!! Form::password('password', [
                                'required' => 'required',
                                'class' =>
                                    'form-control',
                                'placeholder' => 'Input ' . __('employee.password'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        {!! Form::label('password_confirmation', __('employee.password_confirmation'), ['class' => 'form-label required']) !!}
                        <div class="col-12">
                            {!! Form::password('password_confirmation', [
                                'required' => 'required',
                                'class' =>
                                    'form-control',
                                'placeholder' => 'Input ' . __('employee.password_confirmation'),
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a class="btn btn-danger" href="{{ url()->previous() }}">{{ __('general.button_cancel') }}</a>
                    <button type="submit" class="btn btn-success">{{ __('general.button_save') }}</button>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
</section>