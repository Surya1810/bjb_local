@extends('layouts.admin')

@section('title')
Scan Agunan
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('assets/adminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('assets/adminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Scan Agunan</h1>
                <ol class="breadcrumb text-black-50">
                    <li class="breadcrumb-item"><a class="text-black-50" href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active"><strong>Scan Agunan</strong></li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Tabel Agunan -->
            <div class="col-12 col-md-6">
                <div class="card card-outline rounded-partner card-primary">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h3 class="card-title">Agunan List</h3>
                            </div>
                            <div class="col-6">
                                <div class="float-right">
                                    <small>Found : <strong id="totalIsThereTrue">0</strong></small>
                                    <small>Missing : <strong id="totalIsThereFalse">0</strong></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="agunanTable" class="table table-bordered text-nowrap text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Status</th>
                                    <th>No Dokumen</th>
                                    <th>RFID</th>
                                    <th>Jenis Agunan</th>
                                    <th>Nomor Agunan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agunans as $agunan)
                                <tr>
                                    <td>
                                        @if ($agunan->is_there)
                                        <span class="badge badge-success">Found</span>
                                        @else
                                        <span class="badge badge-danger">Missing</span>
                                        @endif
                                    </td>
                                    <td>{{ $agunan->no_dokumen }}</td>
                                    <td>{{ $agunan->rfid_number }}</td>
                                    <td>{{ $agunan->jenis_agunan }}</td>
                                    <td>{{ $agunan->nomor_agunan }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tabel Data Hasil Scan -->
            <div class="col-12 col-md-6">
                <div class="card card-outline rounded-partner card-primary">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h3 class="card-title">Scanned Data</h3>
                            </div>
                            <div class="col-6">
                                <small class="float-right">Total: <strong id="totalRFID">0</strong>
                                    Last checked: <strong>
                                        @isset($last_checked->created_at)
                                        {{ $last_checked->created_at }}
                                        @endisset
                                    </strong>
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="rfidTable" class="table table-bordered text-nowrap text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>RFID</th>
                                    <th>Timestamp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data RFID masuk real-time -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('assets/adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/adminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/adminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/adminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('build/assets/app.js') }}"></script>
@endpush