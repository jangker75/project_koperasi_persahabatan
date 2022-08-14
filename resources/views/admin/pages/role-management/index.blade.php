<x-admin-layout titlePage="{{ $titlePage }}">
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-nowrap border-bottom" id="datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @if ($role->name != 'superadmin')
                                            <a class="btn btn-sm btn-primary badge"
                                                href="{{ route('admin.role-management.edit', [$role]) }}"
                                                type="button">Edit</a>
                                            <a class="btn btn-sm btn-danger badge delete-button" type="button">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            <form method="POST"
                                                action="{{ route('admin.role-management.destroy', [$role]) }}">
                                                <input name="_method" type="hidden" value="delete">
                                                <input name="_token" type="hidden" value="{{ Session::token() }}">
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
