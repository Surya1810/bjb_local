@extends('layouts.admin')

@section('title')
    Document List
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
                    <h1>Document List</h1>
                    <ol class="breadcrumb text-black-50">
                        <li class="breadcrumb-item"><a class="text-black-50" href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><strong>Document List</strong></li>
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
                                    <h3 class="card-title">Document List</h3>
                                    <br>
                                    <small><strong>Total Document: {{ $documents->count() }}</strong></small>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="float-right btn btn-sm btn-primary rounded-partner ml-2"
                                        data-toggle="modal" data-target="#addDocument">
                                        <i class="fa-solid fa-file-export"></i> Export
                                    </button>
                                    <button type="button" class="float-right btn btn-sm btn-primary rounded-partner ml-2"
                                        data-toggle="modal" data-target="#addDocument">
                                        <i class="fa-solid fa-file-import"></i> Import
                                    </button>
                                    <button type="button" class="float-right btn btn-sm btn-primary rounded-partner ml-2"
                                        data-toggle="modal" data-target="#addDocument">
                                        <i class="fa-solid fa-plus"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <table id="documentTable" class="table table-bordered text-center text-sm">
                                <thead class="table-dark">
                                    <tr>
                                        <th rowspan="2" class="align-middle">RFID Number</th>
                                        <th colspan="8">Nasabah</th>
                                        <th colspan="6">Info</th>
                                        <th colspan="4">Location</th>
                                        <th rowspan="2" class="align-middle" style="width: 5%">Action</th>
                                    </tr>
                                    <tr>
                                        <th>CIF</th>
                                        <th>NIK</th>
                                        <th>Rekening</th>
                                        <th>Nama</th>
                                        <th>Telepon</th>
                                        <th>Pekerjaan</th>
                                        <th>Instansi</th>
                                        <th>Alamat</th>
                                        <th>Dokumen</th>
                                        <th>Cabang</th>
                                        <th>Tanggal Akad</th>
                                        <th>Tanggal Jatuh Tempo</th>
                                        <th>Lama Pinjaman</th>
                                        <th>Nilai Pinjaman</th>
                                        <th>Ruangan</th>
                                        <th>Baris</th>
                                        <th>Rak</th>
                                        <th>Box</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($documents as $key => $document)
                                        <tr>
                                            <td>{{ $document->rfid_number }}</td>
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

    <!-- Modal Add Document-->
    <div class="modal fade" id="addDocument" aria-labelledby="addDocumentLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDocumentLabel">Add Document</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('document.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row px-3">
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="tag" class="mb-0 form-label col-form-label-sm">RFID Number</label>
                                    <select class="form-control tag" style="width: 100%;" id="tag" name="tag"
                                        required>
                                        <option></option>
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->rfid_number }}"
                                                {{ old('tag') == $tag->rfid_number ? 'selected' : '' }}>
                                                {{ $tag->rfid_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tag')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="cif" class="mb-0 form-label col-form-label-sm">CIF</label>
                                    <input class="form-control @error('cif') is-invalid @enderror" id="cif"
                                        name="cif" placeholder="CIF nasabah" value="{{ old('cif') }}" required
                                        type="text">
                                    @error('cif')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="nik" class="mb-0 form-label col-form-label-sm">NIK</label>
                                    <input class="form-control @error('nik') is-invalid @enderror" id="nik"
                                        name="nik" placeholder="NIK nasabah" value="{{ old('nik') }}" required
                                        type="number" min="0">
                                    @error('nik')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="nama" class="mb-0 form-label col-form-label-sm">Nama</label>
                                    <input class="form-control @error('nama') is-invalid @enderror" id="nama"
                                        name="nama" placeholder="Nama nasabah" value="{{ old('nama') }}" required
                                        type="text">
                                    @error('nama')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="rekening" class="mb-0 form-label col-form-label-sm">Rekening</label>
                                    <input class="form-control @error('rekening') is-invalid @enderror" id="rekening"
                                        name="rekening" placeholder="Rekening nasabah" value="{{ old('rekening') }}"
                                        required type="number" min="0">
                                    @error('rekening')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="telepon" class="mb-0 form-label col-form-label-sm">Telepon</label>
                                    <input class="form-control @error('telepon') is-invalid @enderror" id="telepon"
                                        name="telepon" placeholder="Telepon nasabah" value="{{ old('telepon') }}"
                                        required type="tel" min="0">
                                    @error('telepon')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="pekerjaan" class="mb-0 form-label col-form-label-sm">Pekerjaan</label>
                                    <input class="form-control @error('pekerjaan') is-invalid @enderror" id="pekerjaan"
                                        name="pekerjaan" placeholder="Pekerjaan nasabah" value="{{ old('pekerjaan') }}"
                                        required type="text">
                                    @error('pekerjaan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="instansi" class="mb-0 form-label col-form-label-sm">Instansi</label>
                                    <input class="form-control @error('instansi') is-invalid @enderror" id="instansi"
                                        name="instansi" placeholder="Instansi nasabah" value="{{ old('instansi') }}"
                                        required type="text">
                                    @error('instansi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="alamat" class="mb-0 form-label col-form-label-sm">Alamat</label>
                                    <input class="form-control @error('alamat') is-invalid @enderror" id="alamat"
                                        name="alamat" placeholder="Alamat nasabah" value="{{ old('alamat') }}" required
                                        type="text">
                                    @error('alamat')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <hr>
                                <p class="m-0 p-0"><strong>Informasi</strong></p>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="Dokumen" class="mb-0 form-label col-form-label-sm">Dokumen</label>
                                    <input class="form-control @error('Dokumen') is-invalid @enderror" id="Dokumen"
                                        name="Dokumen" placeholder="Input informasi dokumen"
                                        value="{{ old('Dokumen') }}" required type="text">
                                    @error('Dokumen')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="segmen" class="mb-0 form-label col-form-label-sm">RFID Number</label>
                                <select class="form-control segmen" style="width: 100%;" id="segmen" name="segmen"
                                    required>
                                    <option></option>
                                    <option value="Konsumer" {{ old('segmen') == 'Konsumer' ? 'selected' : '' }}>Konsumer
                                    </option>
                                    <option value="UMKM" {{ old('segmen') == 'UMKM' ? 'selected' : '' }}>UMKM
                                    </option>
                                    <option value="KPR" {{ old('segmen') == 'KPR' ? 'selected' : '' }}>KPR
                                    </option>
                                    <option value="Komersial" {{ old('segmen') == 'Komersial' ? 'selected' : '' }}>
                                        Komersial
                                    </option>
                                    <option value="Korporasi" {{ old('segmen') == 'Korporasi' ? 'selected' : '' }}>
                                        Korporasi
                                    </option>
                                </select>
                                @error('segmen')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="Cabang" class="mb-0 form-label col-form-label-sm">Cabang</label>
                                    <input class="form-control @error('Cabang') is-invalid @enderror" id="Cabang"
                                        name="Cabang" placeholder="Input cabang" value="{{ old('cabang') }}" required
                                        type="text">
                                    @error('cabang')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="akad" class="mb-0 form-label col-form-label-sm">Tanggal Akad</label>
                                    <input class="form-control @error('akad') is-invalid @enderror" id="akad"
                                        name="akad" required type="date">
                                    @error('akad')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="jatuh_tempo" class="mb-0 form-label col-form-label-sm">Tanggal Jatuh
                                        Tempo</label>
                                    <input class="form-control @error('jatuh_tempo') is-invalid @enderror"
                                        id="jatuh_tempo" name="jatuh_tempo" required type="date">
                                    @error('jatuh_tempo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="lama" class="mb-0 form-label col-form-label-sm">Lama Pinjaman <small
                                            class="text-danger">*Bulan</small></label>
                                    <input class="form-control @error('lama') is-invalid @enderror" id="lama"
                                        name="lama" placeholder="Input lama pinjaman (bulan)"
                                        value="{{ old('lama') }}" required type="number" min="0">
                                    @error('lama')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="nilai" class="mb-0 form-label col-form-label-sm">Nilai Pinjaman</label>
                                    <input type="text" name="nilai" class="form-control price"
                                        placeholder="Input nilai" min="0" step="0.01" required>
                                    @error('nilai')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <hr>
                                <p class="m-0 p-0"><strong>Lokasi</strong></p>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="ruangan" class="mb-0 form-label col-form-label-sm">Ruangan</label>
                                    <input class="form-control @error('ruangan') is-invalid @enderror" id="ruangan"
                                        name="ruangan" placeholder="Tulis ruangan " value="{{ old('ruangan') }}"
                                        required type="text">
                                    @error('ruangan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="baris" class="mb-0 form-label col-form-label-sm">Baris</label>
                                    <select class="form-control baris" style="width: 100%;" id="baris"
                                        name="baris" required>
                                        <option></option>
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->rfid_number }}"
                                                {{ old('tag') == $tag->rfid_number ? 'selected' : '' }}>
                                                {{ $tag->rfid_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('baris')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="rak" class="mb-0 form-label col-form-label-sm">Rak</label>
                                    <select class="form-control rak" style="width: 100%;" id="rak" name="rak"
                                        required>
                                        <option></option>
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->rfid_number }}"
                                                {{ old('tag') == $tag->rfid_number ? 'selected' : '' }}>
                                                {{ $tag->rfid_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('baris')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="box" class="mb-0 form-label col-form-label-sm">Box</label>
                                    <input class="form-control @error('box') is-invalid @enderror" id="box"
                                        name="box" placeholder="Tulis box" value="{{ old('box') }}" required
                                        type="text">
                                    @error('box')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <hr>
                            <p class="m-0 p-0"><strong>Agunan</strong></p>
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
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary rounded-partner">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($documents as $document)
        <!-- Modal Edit Document-->
        <div class="modal fade" id="editDocument{{ $document->id }}" aria-labelledby="editDocumentLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDocumentLabel">Edit Document</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('document.update', $document->id) }}" method="POST"
                        enctype="multipart/form-data">
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
                                        <input class="form-control @error('password') is-invalid @enderror"
                                            id="password" name="password" placeholder="Enter password" required
                                            type="password">
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

    <script src="{{ asset('assets/adminLTE/plugins/inputmask/jquery.inputmask.min.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            $('.price').inputmask({
                alias: 'numeric',
                prefix: 'Rp',
                digits: 0,
                groupSeparator: '.',
                autoGroup: true,
                removeMaskOnSubmit: true,
                rightAlign: false
            });

            $('#documentTable').DataTable({
                "paging": true,
                'processing': true,
                "searching": true,
                "info": true,
                "scrollX": true,
                "order": [],
                // "columnDefs": [{
                //     "orderable": true,
                // }]
            });

            $('.tag').select2({
                placeholder: "Pilih RFID Tag",
                allowClear: true,
            })
            $('.segmen').select2({
                placeholder: "Pilih segmen dokumen",
                allowClear: true,
            })
            $('.tag_agunan').select2({
                placeholder: "Pilih RFID Tag",
                allowClear: true,
            })
            $('.baris').select2({
                placeholder: "Pilih baris",
                allowClear: true,
            })
            $('.rak').select2({
                placeholder: "Pilih rak",
                allowClear: true,
            })
        });

        function deleteDocument(id) {
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

        $(document).ready(function() {
            let rowCount = $('#agunans-table tbody tr').length; // Hitung jumlah baris untuk membuat indeks unik

            // Tambahkan baris baru
            $('#add-item').click(function() {
                const newRow = `
                    <tr>
                        <td>
                            <select class="form-control tag_agunan" style="width: 100%;" id="tag_agunan_${rowCount}"
                                name="agunans[${rowCount}][rfid_number]" required>
                                <option></option>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->rfid_number }}"
                                        {{ old('tag') == $tag->rfid_number ? 'selected' : '' }}>
                                        {{ $tag->rfid_number }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="text" name="agunans[${rowCount}][name]" class="form-control"
                                placeholder="Tulis nama agunan" required></td>
                        <td><input type="text" name="agunans[${rowCount}][number]" class="form-control"
                                placeholder="Tulis nomor agunan" required></td>
                        <td><button type="button"
                                class="btn btn-danger btn-sm remove-item rounded-partner"><i
                                    class="fas fa-trash"></i></button></td>
                    </tr>
                `;
                $('#agunans-table tbody').append(newRow);

                $(`#tag_agunan_${rowCount}`).select2({
                    placeholder: "Pilih RFID Tag",
                    allowClear: true,
                });
            });

            // Hapus baris
            $(document).on('click', '.remove-item', function() {
                $(this).closest('tr').remove();
            });
        });
    </script>
@endpush
