@extends('layouts.admin')

@section('title')
    Tag RFID
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
                    <h1>Tag RFID</h1>
                    <ol class="breadcrumb text-black-50">
                        <li class="breadcrumb-item"><a class="text-black-50" href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><strong>Tag RFID</strong></li>
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
                                    <h3 class="card-title">Tag RFID List</h3>
                                </div>
                                <div class="col-6">
                                    @if (auth()->user()->role_id == 1)
                                        <button type="button"
                                            class="float-right btn btn-sm btn-primary rounded-partner ml-2"
                                            data-toggle="modal" data-target="#injectTag">
                                            <i class="fa-solid fa-plus"></i> Inject
                                        </button>
                                    @endif
                                    <a href="{{ route('tag.export') }}"
                                        class="float-right btn btn-sm btn-primary rounded-partner ml-2">
                                        <i class="fa-solid fa-file-export"></i> Export
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <table id="rfidTable" class="table table-bordered text-nowrap text-center w-100">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 30%">
                                            RFID Number
                                        </th>
                                        <th style="width: 20%">
                                            Status
                                        </th>
                                        <th style="width: 20%">
                                            Created at
                                        </th>
                                        <th style="width: 20%">
                                            Document
                                        </th>
                                        <th style="width: 10%">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rfids as $rfid)
                                        <tr>
                                            <td>{{ $rfid->rfid_number }}</td>
                                            <td>
                                                @if ($rfid->status == 'used')
                                                    <span class="badge badge-warning">
                                                        {{ $rfid->status }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-success">
                                                        {{ $rfid->status }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>{{ $rfid->created_at->format('j F, Y') }}</td>
                                            <td>
                                                @isset($rfid->document->no_dokumen)
                                                    <strong>Dokumen: </strong>{{ $rfid->document->no_dokumen }}
                                                @endisset
                                                @isset($rfid->agunan->number)
                                                    <strong>Agunan: </strong>{{ $rfid->agunan->number }}
                                                @endisset
                                            </td>
                                            <td>
                                                @if ($rfid->status === 'available')
                                                    <button class="btn btn-sm btn-danger rounded-partner"
                                                        onclick="deleteRFID({{ $rfid->rfid_number }})"><i
                                                            class="fas fa-trash"></i></button>
                                                    <form id="delete-form-{{ $rfid->rfid_number }}"
                                                        action="{{ route('tag.destroy', $rfid->rfid_number) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
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
    </section>

    <!-- Modal Import Document-->
    <div class="modal fade" id="injectTag" tabindex="-1" aria-labelledby="injectTagLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="injectTagLabel">Inject Tag RFID</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('tag.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="from" class="mb-0 form-label col-form-label-sm">From</label>
                                    <input class="form-control @error('from') is-invalid @enderror" id="from"
                                        name="from" placeholder="Input Number" value="{{ old('from') }}" required
                                        type="number">
                                    @error('from')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="until" class="mb-0 form-label col-form-label-sm">Until</label>
                                    <input class="form-control @error('until') is-invalid @enderror" id="until"
                                        name="until" placeholder="Input Number" value="{{ old('until') }}" required
                                        type="number">
                                    @error('until')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary rounded-partner">Inject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('assets/adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/adminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/adminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/adminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            $('#rfidTable').DataTable({
                "paging": true,
                'processing': true,
                "searching": true,
                "info": true,
                "scrollX": true,
                "order": [],
            });
        });

        function deleteRFID(id) {
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
