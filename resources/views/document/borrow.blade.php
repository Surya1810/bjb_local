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
                                            value="{{ old('borrowed_by', $document->borrowed_by) }}" required type="text">
                                        @error('borrowed_by')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer rounded-partner">
                                @if (!Str::startsWith($document->status, 'Dipinjam oleh'))
                                <a href="{{ route('document.index') }}" class="btn btn-secondary rounded-partner">Batal</a>
                                
                                <button type="submit" class="btn btn-warning rounded-partner">Pinjam</button>
                                @endif
                            </div>
                            </form>
                            
                            
                            <div class="card-footer rounded-partner">
                                @if (Str::startsWith($document->status, 'Dipinjam oleh'))
                                <a href="{{ route('document.index') }}" class="btn btn-secondary rounded-partner">Batal</a>
                                <form id="delete-form-{{ $document->id }}" action="{{ route('document.return', $document->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger rounded-partner" onclick="deleteBorrow({{ $document->id }})">Hapus</button>
                                </form>
                                @endif
                            </div>
                            
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script src="{{ asset('assets/adminLTE/plugins/inputmask/jquery.inputmask.min.js') }}"></script>

<script type="text/javascript">
    function deleteBorrow(id) {
    Swal.fire({
    title: 'Are you sure?',
    text: "This action cannot be undone!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Delete!'
    }).then((result) => {
    if (result.isConfirmed) {
    document.getElementById('delete-form-' + id).submit();
    }
    });
    }
</script>
@endpush
