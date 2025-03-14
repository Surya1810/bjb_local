@extends('layouts.admin')

@section('title')
    Peminjaman
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Peminjaman</h1>
                    <ol class="breadcrumb text-black-50">
                        <li class="breadcrumb-item"><a class="text-black-50" href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><strong>Peminjaman</strong></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-md-4">
                    <div class="card card-outline rounded-partner card-primary">
                        <form action="{{ route('document.borrow.store', $document->id) }}" method="POST">
                            <div class="card-header">
                                <h3 class="card-title">Peminjaman</h3>
                            </div>
                            <div class="card-body table-responsive">
                                <p><strong>Dokumen: </strong>{{ $document->no_dokumen }} - {{ $document->cif }} -
                                    {{ $document->nama_nasabah }}</p>
                                @csrf
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="borrowed_by" class="mb-0 form-label col-form-label-sm">Nama
                                            Peminjam</label>
                                        <input class="form-control @error('borrowed_by') is-invalid @enderror"
                                            id="borrowed_by" name="borrowed_by" placeholder="Tulis nama peminjam"
                                            value="{{ old('borrowed_by') }}" required type="text">
                                        @error('borrowed_by')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer rounded-partner">
                                <a href="{{ route('document.index') }}" class="btn btn-secondary rounded-partner">Batal</a>
                                <button type="submit" class="btn btn-warning rounded-partner">Pinjam</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
@endpush
