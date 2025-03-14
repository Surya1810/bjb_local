@extends('layouts.admin')

@section('title')
    User List
@endsection

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/adminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/adminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>User List</h1>
                    <ol class="breadcrumb text-black-50">
                        <li class="breadcrumb-item"><a class="text-black-50" href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><strong>User List</strong></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline rounded-partner card-primary">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <h3 class="card-title">User List</h3>
                                </div>
                                <div class="col-6">
                                    @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                                        <button type="button"
                                            class="float-right btn btn-sm btn-primary rounded-partner ml-2"
                                            data-toggle="modal" data-target="#addUser">
                                            <i class="fa-solid fa-plus"></i> Add
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <table id="userTable" class="table table-bordered text-nowrap text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 5%">
                                            No
                                        </th>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Role
                                        </th>
                                        <th style="width: 5%">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $user)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->role->name }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning rounded-partner"
                                                    data-toggle="modal" data-target="#editUser{{ $user->id }}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger rounded-partner"
                                                    onclick="deleteUser({{ $user->id }})"><i
                                                        class="fas fa-trash"></i></button>
                                                <form id="delete-form-{{ $user->id }}"
                                                    action="{{ route('user.destroy', $user->id) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
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
    </section>

    <!-- Modal Add User-->
    <div class="modal fade" id="addUser" aria-labelledby="addUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserLabel">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name" class="mb-0 form-label col-form-label-sm">Name</label>
                                    <input class="form-control @error('name') is-invalid @enderror" id="name"
                                        name="name" placeholder="Enter user name" value="{{ old('name') }}" required
                                        type="text">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="role">role</label>
                                    <select class="form-control role" style="width: 100%;" id="role" name="role">
                                        <option></option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ old('role') == $role->id ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="password" class="mb-0 form-label col-form-label-sm">Password</label>
                                    <input class="form-control @error('password') is-invalid @enderror" id="password"
                                        name="password" placeholder="Enter password" required type="password" required>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="confirm_password" class="mb-0 form-label col-form-label-sm">Confirm
                                        Password</label>
                                    <input class="form-control @error('confirm_password') is-invalid @enderror"
                                        id="confirm_password" name="confirm_password"
                                        placeholder="Enter password confirmation" required type="password" required>
                                    @error('confirm_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary rounded-partner">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($users as $user)
        <!-- Modal Add User-->
        <div class="modal fade" id="editUser{{ $user->id }}" aria-labelledby="editUserLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserLabel">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name" class="mb-0 form-label col-form-label-sm">Name</label>
                                        <input class="form-control @error('name') is-invalid @enderror" id="name"
                                            name="name" placeholder="Enter user name" value="{{ $user->name }}"
                                            required type="text">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="role_update">Role</label>
                                        <select class="form-control role_update" style="width: 100%;" id="role_update"
                                            name="role_update">
                                            @foreach ($roles as $role)
                                                <option {{ $user->role->id == $role->id ? 'selected' : '' }}
                                                    value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('role_update')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="password" class="mb-0 form-label col-form-label-sm">Password</label>
                                        <input class="form-control @error('password') is-invalid @enderror" id="password"
                                            name="password" placeholder="Enter password" required type="password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="confirm_password" class="mb-0 form-label col-form-label-sm">
                                            Password Confirmation</label>
                                        <input class="form-control @error('confirm_password') is-invalid @enderror"
                                            id="confirm_password" name="confirm_password"
                                            placeholder="Enter password confirmation" required type="password">
                                        @error('confirm_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-warning rounded-partner">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('assets/adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/adminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/adminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/adminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            $('#userTable').DataTable({
                "paging": true,
                'processing': true,
                "searching": true,
                "info": true,
                "scrollX": true,
                "order": [],
            });

            $('.role').select2({
                placeholder: "Select Role",
                allowClear: true,
            })

            $('.role_update').select2({
                placeholder: "Select Role",
                allowClear: true,
            })
        });

        function deleteUser(id) {
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-form-' + id).submit();
                } else if (
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'Your data is safe !',
                        'error'
                    )
                }
            })
        }
    </script>
@endpush
