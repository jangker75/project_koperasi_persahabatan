<x-admin-layout titlePage="{{ $titlePage }}">
    @include('nasabah.shared.form_error')
    <a href="{{ $currentIndex }}" type="button" class="btn btn-danger mb-3">{{ __('general.button_cancel') }}</a>
    <div class="row">
        <div class="col-lg-12">
            {!! Form::open([
                'route' => ['admin.role-management.update', $role],
                'files' => true,
                'method' => 'PUT',
                'class' => 'form-horizontal']) !!}
            @csrf
            <div class="card">
                <div class="card-body">

                    {!! Form::label('name', __('role.name'), ['class' => 'col-md-3 form-label required']) !!}
                    <div class="col-md-12">
                        {!! Form::text('name', $role->name, [
                            'required' => 'required',
                            'class' =>
                                'form-control ' .
                                ($errors->has('name') ? ' is-invalid' : '') .
                                (!$errors->has('name') && old('name') ? ' is-valid' : ''),
                            'placeholder' => 'Input ' . __('role.name'),
                        ]) !!}
                    </div>
                    <div id="permission-section">
                        {!! Form::label('permission', __('role.permission'), ['class' => 'col-md-3 form-label']) !!}
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-nowrap border-bottom" id="datatable">
                                <thead>
                                    <tr>
                                        <th>Nama permission</th>
                                        <th>Read</th>
                                        <th>Create</th>
                                        <th>Update</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <input type="checkbox" id="check-all-read">
                                        </td>
                                        <td>
                                            <input type="checkbox" id="check-all-create">
                                        </td>
                                        <td>
                                            <input type="checkbox" id="check-all-update">
                                        </td>
                                        <td>
                                            <input type="checkbox" id="check-all-delete">
                                        </td>
                                    </tr>
                                    @foreach ($menuList as $index => $menu)
                                        @php
                                            if (!$menu->isseparator) {
                                                $url = explode('/', $menu->url);
                                                $namePermission = $url[count($url) - 1];
                                            } else {
                                                $namePermission = str_replace(' ', '_', strtolower($menu->name));
                                            }
                                            $permissionRead = 'read ' . $namePermission;
                                            $permissionCreate = 'create ' . $namePermission;
                                            $permissionUpdate = 'update ' . $namePermission;
                                            $permissionDelete = 'delete ' . $namePermission;
                                        @endphp
                                        <tr>
                                            <td>
                                                @if ($menu->isseparator)
                                                    {{ $menu->name }}
                                                @elseif($menu->main_menu_id == null)
                                                    <div class="ms-3">
                                                        - {{ $menu->name }}
                                                    </div>
                                                @else
                                                    <div class="ms-5">
                                                        -- {{ $menu->name }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="checkbox"
                                                    name="{{ $permissionRead }}"
                                                    {{ $role->hasPermissionTo($permissionRead) ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                <input type="checkbox"
                                                name="{{ $permissionRead }}"
                                                    {{ $role->hasPermissionTo($permissionCreate) ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                <input type="checkbox"
                                                name="{{ $permissionRead }}"
                                                    {{ $role->hasPermissionTo($permissionUpdate) ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                <input type="checkbox"
                                                name="{{ $permissionRead }}"
                                                    {{ $role->hasPermissionTo($permissionDelete) ? 'checked' : '' }}>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
</x-admin-layout>
