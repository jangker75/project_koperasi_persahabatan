<x-admin-layout>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    {!! Form::open(['route' => 'admin.app-setting.update', 'files' => true]) !!}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    @foreach ($appsetting as $item)
                        <div class="form-group">
                            {!! Form::label($item->name, $item->label, ['class' => 'col-form-label pt-0']) !!}
                            <div class="row">
                                <div class="col-md-6">
                                    @if ($item->type == 'text')
                                        {!! Form::text($item->name, $item->content, [
                                            'class' =>
                                                'form-control' .
                                                ($errors->has($item->name) ? ' is-invalid' : '') .
                                                (!$errors->has($item->name) && old($item->name) ? ' is-valid' : ''),
                                            'placeholder' => 'Input ' . $item->label,
                                        ]) !!}
                                    @elseif($item->type == 'number')
                                        {!! Form::number($item->name, $item->content, [
                                            'class' =>
                                                'form-control' .
                                                ($errors->has($item->name) ? ' is-invalid' : '') .
                                                (!$errors->has($item->name) && old($item->name) ? ' is-valid' : ''),
                                            'placeholder' => 'Input ' . $item->label,
                                        ]) !!}
                                    @elseif($item->type == 'textarea')
                                        {!! Form::textarea($item->name, $item->content, [
                                            'rows' => 4,
                                            'class' =>
                                                'form-control' .
                                                ($errors->has($item->name) ? ' is-invalid' : '') .
                                                (!$errors->has($item->name) && old($item->name) ? ' is-valid' : ''),
                                            'placeholder' => 'Input .' . $item->name,
                                        ]) !!}
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    {!! Form::label($item->description, $item->description, ['class' => 'col-form-label']) !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">Save Changes</button>
        </div>
    </div>
    {!! Form::close() !!}
</x-admin-layout>
