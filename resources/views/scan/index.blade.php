@extends('layouts.admin')

@section('title')
    Scan
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
                    <h1>Scan</h1>
                    <ol class="breadcrumb text-black-50">
                        <li class="breadcrumb-item"><a class="text-black-50" href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><strong>Scan</strong></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card card-outline rounded-partner card-primary">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <h3 class="card-title">Document List</h3>
                                </div>
                                <div class="col-6">
                                    <div class="float-right">
                                        <small>Found : <strong id="totalIsThereTrue">0</strong>
                                        </small>
                                        <small>Missing : <strong id="totalIsThereFalse">0</strong>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <table id="documentTable" class="table table-bordered text-nowrap text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th rowspan="2" class="align-middle">
                                            Status
                                        </th>
                                        <th rowspan="2" class="align-middle">
                                            RFID
                                        </th>
                                        <th rowspan="2" class="align-middle">
                                            CIF
                                        </th>
                                        <th rowspan="2" class="align-middle">
                                            NIK
                                        </th>
                                        <th rowspan="2" class="align-middle">
                                            Rekening
                                        </th>
                                        <th rowspan="2" class="align-middle">
                                            Nama
                                        </th>
                                        <th rowspan="2" class="align-middle">
                                            Cabang
                                        </th>
                                        <th rowspan="2" class="align-middle">
                                            Dokumen
                                        </th>
                                        <th rowspan="2" class="align-middle">
                                            Segmen
                                        </th>
                                        <th rowspan="2" class="align-middle">
                                            Nilai
                                        </th>
                                        <th colspan="3" class="align-middle">
                                            Location
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Ruangan</th>
                                        <th>Baris</th>
                                        <th>Rak</th>
                                        <th>Box</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data Asset masuk real-time -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card card-outline rounded-partner card-primary">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <h3 class="card-title">Scanned Data</h3>
                                </div>
                                <div class="col-6">
                                    <small class="float-right">Total :<strong id="totalRFID">0</strong>
                                        last checked: <strong>{{ !empty($last_checked->created_at) }}</strong>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <table id="rfidTable" class="table table-bordered text-nowrap text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 70%">
                                            RFID
                                        </th>
                                        <th style="width: 30%">
                                            Timestamp
                                        </th>
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
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('assets/adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/adminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/adminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/adminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('build/assets/app.js') }}"></script>
@endpush
