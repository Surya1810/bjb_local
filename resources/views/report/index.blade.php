@extends('layouts.admin')

@section('title')
    Report
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
                    <h1>Report</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Total User -->
                <div class="col-md-2 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ number_format($totalUser) }}</h3>
                            <p>Total User</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Documents -->
                <div class="col-md-2 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ number_format($totalDocuments) }}</h3>
                            <p>Total Documents</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-regular fa-folder-open"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Agunan -->
                <div class="col-md-2 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ number_format($totalAgunan) }}</h3>
                            <p>Total Agunan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-regular fa-file"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Nilai Document -->
                <div class="col-md-2 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h4 class="mb-4">{{ formatRupiah($totalNilaiDocument) }}</h4>
                            <p>Total Nilai Document</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                </div>

                <!-- Found Documents -->
                <div class="col-md-2 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ number_format($totalKetemu) }}</h3>
                            <p>Found</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>

                <!-- Missing Documents -->
                <div class="col-md-2 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ number_format($totalHilang) }}</h3>
                            <p>Missing</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Log Scan -->
                <div class="col-12">
                    <div class="card card-outline card-primary rounded-partner">
                        <div class="card-header">
                            <h3 class="card-title">History Scan</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="logTable" class="table table-bordered text-sm">
                                    <thead>
                                        <tr>
                                            <th>Last Scan</th>
                                            <th>Category</th>
                                            <th>Total Scanned</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($logScans as $log)
                                            <tr>
                                                <td>{{ $log->updated_at }}</td>
                                                <td>{{ $log->category }}</td>
                                                <td>{{ $log->total }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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

    <script>
        $('#logTable').DataTable({
            "paging": false,
            'processing': true,
            "searching": false,
            "info": false,
            "scrollX": false,
            "order": [],
        });
    </script>
@endpush
