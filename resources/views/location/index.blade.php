@extends('layouts.admin')

@section('title')
    Location List
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
                    <h1>Location</h1>
                    <ol class="breadcrumb text-black-50">
                        <li class="breadcrumb-item"><a class="text-black-50" href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><strong>Location</strong></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Baris List -->
                <div class="col-12 col-md-6">
                    <div class="card card-outline rounded-partner card-primary">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <h3 class="card-title">Baris List</h3>
                                </div>
                                <div class="col-6 text-right">
                                    <button type="button" class="btn btn-sm btn-primary rounded-partner ml-2"
                                        data-toggle="modal" data-target="#addLocation" onclick="setCategory('baris')">
                                        <i class="fa-solid fa-plus"></i> Add Baris
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body table-responsive">
                            <table id="barisTable" class="table table-bordered text-nowrap text-center rounded-partner">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Baris</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($locations as $location)
                                        @if ($location->for == 'baris')
                                            <tr>
                                                <td>{{ $location->number }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger rounded-partner"
                                                        onclick="deleteLocation({{ $location->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $location->id }}"
                                                        action="{{ route('location.destroy', $location->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Rak List -->
                <div class="col-12 col-md-6">
                    <div class="card card-outline rounded-partner card-primary">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <h3 class="card-title">Rak List</h3>
                                </div>
                                <div class="col-6 text-right">
                                    <button type="button" class="btn btn-sm btn-primary rounded-partner ml-2"
                                        data-toggle="modal" data-target="#addLocation" onclick="setCategory('rak')">
                                        <i class="fa-solid fa-plus"></i> Add Rak
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body table-responsive">
                            <table id="rakTable" class="table table-bordered text-nowrap text-center rounded-partner">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Rak</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($locations as $location)
                                        @if ($location->for == 'rak')
                                            <tr>
                                                <td>{{ $location->number }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger rounded-partner"
                                                        onclick="deleteLocation({{ $location->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $location->id }}"
                                                        action="{{ route('location.destroy', $location->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Add Location -->
    <div class="modal fade" id="addLocation" tabindex="-1" aria-labelledby="addLocationLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-partner">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLocationLabel">Add Location</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('location.store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="locationCategory" name="for">

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="number_from">From</label>
                            <input type="number" class="form-control rounded-partner" id="number_from" name="number_from"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="number_until">Until</label>
                            <input type="number" class="form-control rounded-partner" id="number_until" name="number_until"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary rounded-partner">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/adminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/adminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#barisTable').DataTable();
            $('#rakTable').DataTable();
        });

        function setCategory(category) {
            document.getElementById('locationCategory').value = category;
        }

        function deleteLocation(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endpush
