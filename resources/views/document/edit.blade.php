@extends('layouts.admin')

@section('title')
    Edit Document
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Document</h1>
                    <ol class="breadcrumb text-black-50">
                        <li class="breadcrumb-item"><a class="text-black-50" href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><strong>Edit Document</strong></li>
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
                        <form action="{{ route('document.update', $document->id) }}" method="POST"
                            enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            @method('PUT')
                            <div class="card-header">
                                <h3 class="card-title">Edit Document</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Informasi Nasabah -->
                                    <div class="col-12 text-center">
                                        <p class="m-0 p-0"><strong>Informasi Nasabah</strong></p>
                                    </div>

                                    <!-- RFID Number (Hanya Ditampilkan, Tidak Bisa Diedit) -->
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="rfid" class="mb-0 form-label col-form-label-sm">RFID
                                                Number</label>
                                            <input type="text" id="rfid" class="form-control"
                                                value="{{ $document->rfid_number }}" disabled>
                                        </div>
                                    </div>

                                    <!-- CIF -->
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="cif" class="mb-0 form-label col-form-label-sm">CIF</label>
                                            <input type="text" id="cif" name="cif"
                                                class="form-control @error('cif') is-invalid @enderror"
                                                placeholder="CIF nasabah" value="{{ old('cif', $document->cif) }}" required>
                                            @error('cif')
                                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- NIK -->
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="nik" class="mb-0 form-label col-form-label-sm">NIK</label>
                                            <input type="number" id="nik" name="nik"
                                                class="form-control @error('nik') is-invalid @enderror"
                                                placeholder="NIK nasabah" value="{{ old('nik', $document->nik_nasabah) }}"
                                                required min="0">
                                            @error('nik')
                                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="nama" class="mb-0 form-label col-form-label-sm">Nama</label>
                                            <input class="form-control @error('nama') is-invalid @enderror" id="nama"
                                                name="nama" placeholder="Nama nasabah"
                                                value="{{ $document->nama_nasabah ?? old('nama') }}" required
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
                                            <input class="form-control @error('rekening') is-invalid @enderror"
                                                id="rekening" name="rekening" placeholder="Rekening nasabah"
                                                value="{{ $document->rekening_nasabah ?? old('rekening') }}" required
                                                type="number" min="0">
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
                                            <input class="form-control @error('telepon') is-invalid @enderror"
                                                id="telepon" name="telepon" placeholder="Telepon nasabah"
                                                value="{{ $document->telp_nasabah ?? old('telepon') }}" required
                                                type="tel" min="0">
                                            @error('telepon')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="pekerjaan"
                                                class="mb-0 form-label col-form-label-sm">Pekerjaan</label>
                                            <input class="form-control @error('pekerjaan') is-invalid @enderror"
                                                id="pekerjaan" name="pekerjaan" placeholder="Pekerjaan nasabah"
                                                value="{{ $document->pekerjaan_nasabah ?? old('pekerjaan') }}" required
                                                type="text">
                                            @error('pekerjaan')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="instansi"
                                                class="mb-0 form-label col-form-label-sm">Instansi</label>
                                            <input class="form-control @error('instansi') is-invalid @enderror"
                                                id="instansi" name="instansi" placeholder="Instansi nasabah"
                                                value="{{ $document->instansi ?? old('instansi') }}" required
                                                type="text">
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
                                            <input class="form-control @error('alamat') is-invalid @enderror"
                                                id="alamat" name="alamat" placeholder="Alamat nasabah"
                                                value="{{ $document->alamat_nasabah ?? old('alamat') }}" required
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
                                        <p class="m-0 p-0"><strong>Informasi Dokumen</strong></p>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="dokumen"
                                                class="mb-0 form-label col-form-label-sm">Dokumen</label>
                                            <input class="form-control @error('dokumen') is-invalid @enderror"
                                                id="dokumen" name="dokumen" value="{{ $document->no_dokumen }}"
                                                disabled>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="segmen" class="mb-0 form-label col-form-label-sm">Segmen</label>
                                            <select class="form-control w-100 segmen" id="segmen" name="segmen"
                                                required>
                                                <option></option>
                                                <option value="Konsumer"
                                                    {{ $document->segmen == 'Konsumer' ? 'selected' : (old('segmen') == 'Konsumer' ? 'selected' : '') }}>
                                                    Konsumer
                                                </option>
                                                <option value="UMKM"
                                                    {{ $document->segmen == 'UMKM' ? 'selected' : (old('segmen') == 'UMKM' ? 'selected' : '') }}>
                                                    UMKM
                                                </option>
                                                <option value="KPR"
                                                    {{ $document->segmen == 'KPR' ? 'selected' : (old('segmen') == 'KPR' ? 'selected' : '') }}>
                                                    KPR
                                                </option>
                                                <option value="Komersial"
                                                    {{ $document->segmen == 'Komersial' ? 'selected' : (old('segmen') == 'Komersial' ? 'selected' : '') }}>
                                                    Komersial
                                                </option>
                                                <option value="Korporasi"
                                                    {{ $document->segmen == 'Korporasi' ? 'selected' : (old('segmen') == 'Korporasi' ? 'selected' : '') }}>
                                                    Korporasi
                                                </option>
                                            </select>
                                            @error('segmen')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="cabang" class="mb-0 form-label col-form-label-sm">Cabang</label>
                                            <input class="form-control @error('cabang') is-invalid @enderror"
                                                id="cabang" name="cabang" placeholder="Input cabang"
                                                value="{{ $document->cabang ?? old('cabang') }}" required type="text">
                                            @error('cabang')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label for="akad" class="mb-0 form-label col-form-label-sm">Tanggal
                                                Akad</label>
                                            <input class="form-control @error('akad') is-invalid @enderror"
                                                id="akad" name="akad"
                                                value="{{ old('akad', optional($document->akad)->format('Y-m-d') ?? date('Y-m-d')) }}"
                                                required type="date">
                                            @error('akad')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label for="editJatuhTempo" class="mb-0 form-label col-form-label-sm">Tanggal
                                                Jatuh Tempo</label>
                                            <input class="form-control @error('jatuh_tempo') is-invalid @enderror"
                                                id="editJatuhTempo" name="jatuh_tempo"
                                                value="{{ old('jatuh_tempo', optional($document->jatuh_tempo)->format('Y-m-d') ?? date('Y-m-d')) }}"
                                                required type="date">
                                            @error('jatuh_tempo')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label for="editLama" class="mb-0 form-label col-form-label-sm">Lama Pinjaman
                                                <small class="text-danger">*Bulan</small></label>
                                            <input class="form-control @error('lama') is-invalid @enderror"
                                                id="editLama" name="lama" placeholder="Input lama pinjaman (bulan)"
                                                value="{{ $document->lama ?? old('lama') }}" required type="number"
                                                min="0">
                                            @error('lama')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label for="editNilai" class="mb-0 form-label col-form-label-sm">Nilai
                                                Pinjaman</label>
                                            <input type="text" name="nilai" class="form-control price"
                                                id="editNilai" placeholder="Input nilai"
                                                value="{{ old('nilai', $document->pinjaman ?? '') }}" required>
                                            @error('nilai')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Lokasi -->
                                    <div class="col-12 text-center">
                                        <hr>
                                        <p class="m-0 p-0"><strong>Lokasi</strong></p>
                                    </div>

                                    <!-- Ruangan -->
                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label for="editRuangan"
                                                class="mb-0 form-label col-form-label-sm">Ruangan</label>
                                            <input class="form-control @error('ruangan') is-invalid @enderror"
                                                id="editRuangan" name="ruangan" placeholder="Input Ruangan"
                                                value="{{ $document->room ?? old('ruangan') }}" required type="text">
                                            @error('ruangan')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Baris -->
                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label for="editBaris" class="mb-0 form-label col-form-label-sm">Baris</label>
                                            <select id="editBaris" name="baris" class="form-control baris" required>
                                                <option></option>
                                                @foreach ($rows as $row)
                                                    <option value="{{ $row->number }}"
                                                        {{ old('baris', $document->row) == $row->number ? 'selected' : '' }}>
                                                        Baris {{ $row->number }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('baris')
                                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Rak -->
                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label for="editRak" class="mb-0 form-label col-form-label-sm">Rak</label>
                                            <select class="form-control rak" style="width: 100%;" id="editRak"
                                                name="rak" required>
                                                <option></option>
                                                @foreach ($racks as $rack)
                                                    <option value="{{ $rack->number }}"
                                                        {{ $document->rack == $rack->number ? 'selected' : (old('rak') == $rack->number ? 'selected' : '') }}>
                                                        Rak {{ $rack->number }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('rak')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Box -->
                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label for="editBox" class="mb-0 form-label col-form-label-sm">Box</label>
                                            <input class="form-control @error('box') is-invalid @enderror" id="editBox"
                                                name="box" placeholder="Input box"
                                                value="{{ $document->box ?? old('box') }}" required type="text">
                                            @error('box')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer rounded-partner">
                                <a href="{{ route('document.index') }}"
                                    class="btn btn-secondary rounded-partner">Batal</a>
                                <button type="submit" class="btn btn-warning rounded-partner">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
            // Inisialisasi Inputmask untuk input dengan class "price"
            $('.price').inputmask({
                alias: 'numeric',
                prefix: 'Rp ', // Awalan "Rp"
                digits: 0, // Tidak ada desimal
                groupSeparator: '.', // Pemisah ribuan
                autoGroup: true, // Aktifkan pemisahan ribuan
                removeMaskOnSubmit: true, // Kirim nilai tanpa format ke server
                rightAlign: false // Teks rata kiri
            });

            $('.segmen').select2({
                placeholder: "Pilih segmen dokumen",
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
    </script>
@endpush
