@extends('layouts.admin')

@section('title')
    Agunan List
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
                    <h1>Agunan List</h1>
                    <ol class="breadcrumb text-black-50">
                        <li class="breadcrumb-item"><a class="text-black-50" href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><strong>Agunan List</strong></li>
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
                                    <h3 class="card-title">Agunan List</h3>
                                    <br>
                                    <small><strong>Total Agunan: {{ $agunans->count() }}</strong></small>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('agunan.export') }}"
                                        class="float-right btn btn-sm btn-primary rounded-partner ml-2">
                                        <i class="fa-solid fa-file-export"></i> Export
                                    </a>
                                    <button type="button" class="float-right btn btn-sm btn-primary rounded-partner ml-2"
                                        data-toggle="modal" data-target="#importAgunan">
                                        <i class="fa-solid fa-file-import"></i> Import
                                    </button>
                                    <button type="button" class="float-right btn btn-sm btn-primary rounded-partner ml-2"
                                        data-toggle="modal" data-target="#addAgunan">
                                        <i class="fa-solid fa-plus"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <table id="agunanTable" class="table table-bordered text-center text-sm">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Dokumen</th>
                                        <th>RFID Number</th>
                                        <th>Nama/Jenis Agunan</th>
                                        <th>Nomor Agunan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($documents as $index => $document)
                                        @php
                                            $firstRow = true; // Menandai baris pertama
                                        @endphp
                                        @if (count($document->agunans) > 0)
                                            @foreach ($document->agunans as $agunan)
                                                <tr>
                                                    @if ($firstRow)
                                                        <td>{{ $document->no_dokumen }}</td>
                                                        @php $firstRow = false; @endphp
                                                    @else
                                                        <td></td>
                                                    @endif
                                                    <td>{{ $agunan->rfid_number ?? '-' }}</td>
                                                    <td>{{ $agunan->name ?? '-' }}</td>
                                                    <td>{{ $agunan->number ?? '-' }}</td>
                                                    <td><button type="button"
                                                            class="btn btn-sm btn-warning rounded-partner"
                                                            data-toggle="modal"
                                                            data-target="#editAgunan{{ $agunan->id }}">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger rounded-partner"
                                                            onclick="deleteAgunan({{ $agunan->id }})"><i
                                                                class="fas fa-trash"></i></button>
                                                        <form id="delete-form-{{ $agunan->id }}"
                                                            action="{{ route('agunan.destroy', $agunan->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>{{ $document->no_dokumen }}</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
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

    <!-- Modal Add Agunan-->
    <div class="modal fade" id="addAgunan" aria-labelledby="addAgunanLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAgunanLabel">Add Agunan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('agunan.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="row px-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="dokumen" class="mb-0 form-label col-form-label-sm">Document <small
                                            class="text-danger">*RFID - Dokumen - CIF</small></label>
                                    <select class="form-control dokumen" style="width: 100%;" id="dokumen" name="dokumen"
                                        required>
                                        <option></option>
                                        @foreach ($documents as $document)
                                            <option value="{{ $document->id }}"
                                                {{ old('document') == $document->id ? 'selected' : '' }}>
                                                {{ $document->rfid_number }} - {{ $document->no_dokumen }} -
                                                {{ $document->cif }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('document')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <table class="table table-bordered text-sm w-100" id="agunans-table">
                                <thead>
                                    <tr>
                                        <th>RFID Number</th>
                                        <th>Nama/Jenis Agunan</th>
                                        <th>Nomor Dokumen Agunan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select class="form-control tag_agunan" style="width: 100%;" id="tag_agunan"
                                                name="agunans[0][rfid_number]" required>
                                                <option></option>
                                                @foreach ($tags as $tag)
                                                    <option value="{{ $tag->rfid_number }}"
                                                        {{ old('tag') == $tag->rfid_number ? 'selected' : '' }}>
                                                        {{ $tag->rfid_number }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="text" name="agunans[0][name]" class="form-control"
                                                placeholder="Tulis nama agunan" required></td>
                                        <td><input type="text" name="agunans[0][number]" class="form-control"
                                                placeholder="Tulis nomor agunan" required></td>
                                        <td><button type="button"
                                                class="btn btn-danger btn-sm remove-item rounded-partner"><i
                                                    class="fas fa-trash"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="button" id="add-item" class="btn btn-primary btn-sm rounded-partner"><i
                                    class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary rounded-partner">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($agunans as $agunan)
        <!-- Modal Edit Agunan-->
        <div class="modal fade" id="editAgunan{{ $agunan->id }}" aria-labelledby="editAgunanLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAgunanLabel">Edit Agunan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('agunan.update', $agunan->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row px-3">
                                <div class="col-12 col-md-8">
                                    <div class="form-group">
                                        <label class="mb-0 form-label col-form-label-sm">Dokumen</label>
                                        <input class="form-control"
                                            value="{{ $agunan->document->rfid_number }} - {{ $agunan->document->no_dokumen }} - {{ $agunan->document->cif }}"
                                            disabled>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label class="mb-0 form-label col-form-label-sm">RFID Number</label>
                                        <input class="form-control" value="{{ $agunan->rfid_number }}" disabled>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="mb-0 form-label col-form-label-sm">Nama/Jenis
                                            Agunan</label>
                                        <input class="form-control @error('name') is-invalid @enderror" id="name"
                                            name="name" placeholder="Tulis Nama/Jenis Agunan"
                                            value="{{ $agunan->name }}" required type="text">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="number" class="mb-0 form-label col-form-label-sm">Nomor Dokumen
                                            Agunan</label>
                                        <input class="form-control @error('number') is-invalid @enderror" id="number"
                                            name="number" placeholder="Tulis Nomor Dokumen Agunan"
                                            value="{{ $agunan->number }}" required type="text">
                                        @error('number')
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

    <!-- Modal Import Agunan-->
    <div class="modal fade" id="importAgunan" tabindex="-1" aria-labelledby="importAgunanLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importAgunanLabel">Import Agunan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('agunan.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="file" class="mb-0 form-label col-form-label-sm">Upload File</label>
                            <input class="form-control @error('file') is-invalid @enderror" id="file" name="file"
                                placeholder="Choose file" value="{{ old('file') }}" required type="file"
                                accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            @error('file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary rounded-partner">Import</button>
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
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable("#agunanTable")) {
                $("#agunanTable").DataTable().clear().destroy();
            }
            $('#agunanTable').DataTable({
                "paging": true,
                'processing': true,
                "searching": true,
                "info": true,
                "scrollX": false,
                "order": [],
                // "columnDefs": [{
                //     "orderable": true,
                // }]
            });
            $(function() {
                $('.dokumen').select2({
                    placeholder: "Pilih dokumen",
                    allowClear: true,
                })
                $('.tag_agunan').select2({
                    placeholder: "Pilih RFID Tag",
                    allowClear: true,
                })
            });

            let itemIndex = 1;

            // Tambahkan baris baru
            $('#add-item').click(function() {
                const newRow = `
                    <tr>
                        <td>
                            <select class="form-control tag_agunan" style="width: 100%;" id="tag_agunan_${itemIndex}"
                                name="agunans[${itemIndex}][rfid_number]" required>
                                <option></option>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->rfid_number }}"
                                        {{ old('tag') == $tag->rfid_number ? 'selected' : '' }}>
                                        {{ $tag->rfid_number }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="text" name="agunans[${itemIndex}][name]" class="form-control"
                                placeholder="Tulis nama agunan" required></td>
                        <td><input type="text" name="agunans[${itemIndex}][number]" class="form-control"
                                placeholder="Tulis nomor agunan" required></td>
                        <td><button type="button"
                                class="btn btn-danger btn-sm remove-item rounded-partner"><i
                                    class="fas fa-trash"></i></button></td>
                    </tr>
                `;
                $('#agunans-table tbody').append(newRow);

                $(`#tag_agunan_${itemIndex}`).select2({
                    placeholder: "Pilih RFID Tag",
                    allowClear: true,
                });

                itemIndex++;
            });

            // Hapus baris
            $(document).on('click', '.remove-item', function() {
                $(this).closest('tr').remove();
            });
        });


        function deleteAgunan(id) {
            Swal.fire({
                title: 'Are you sure agunan will be deleted?',
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
