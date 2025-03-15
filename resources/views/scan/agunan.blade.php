@extends('layouts.admin')

@section('title')
    Scan Agunan
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
                                <div class="col-6 text-right">
                                    <small>Found: <strong id="totalIsThereTrue">0</strong></small>
                                    <small>Missing: <strong id="totalIsThereFalse">0</strong></small>
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
                                        <td>{{ $agunan->document_id }}</td>
                                        <td>{{ $agunan->rfid_number }}</td>
                                        <td>{{ $agunan->name }}</td>
                                        <td>{{ $agunan->number }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                
                        <div class="card-footer text-center">
                            <div class="btn-group">
                                <a href="{{ url('/agunans/export/missing/pdf') }}" class="btn btn-danger btn-sm">
                                    <i class="fas fa-file-pdf"></i> Missing PDF
                                </a>
                                <a href="{{ url('/agunans/export/missing/excel') }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-file-excel"></i> Missing Excel
                                </a>
                            </div>
                            <div class="btn-group ml-2">
                                <a href="{{ url('/agunans/export/found/pdf') }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-file-pdf"></i> Found PDF
                                </a>
                                <a href="{{ url('/agunans/export/found/excel') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-file-excel"></i> Found Excel
                                </a>
                            </div>
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
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('assets/adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/adminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/adminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/adminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('build/assets/app.js') }}"></script>

    <script>
        // Inisialisasi DataTable
        let rfidtable = $('#rfidTable').DataTable({
            "paging": true,
            "processing": true,
            "lengthChange": true,
            "searching": true,
            "info": true,
            "autoWidth": false,
            "responsive": false,
            "ordering": true,
            "serverSide": false,
            "destroy": true,
            "oLanguage": {
                "sEmptyTable": "Waiting scanner data"
            },
            columns: [{
                    data: 'rfid_number'
                },
                {
                    data: 'timestamp'
                }
            ]
        });

        let documentTable = $('#agunanTable').DataTable({
            "paging": true,
            "processing": true,
            "lengthChange": true,
            "searching": true,
            "info": true,
            "autoWidth": false,
            "responsive": false,
            "ordering": false,
            "scrollX": true,
            "serverSide": false,
            "destroy": true,
        });

        // Variabel untuk menyimpan jumlah total
        let totalRFID = 0;
        let totalIsThereTrue = 0;
        let totalIsThereFalse = 0;

        window.Echo.channel("tag-scanned").listen("TagScanned", (event) => {
            totalRFID = event.scannedTags.length;

            updateDocumentTable(() => {
                updateRFIDTable(event);
            });
        });

        // ========== FUNGSI UPDATE TABLE Document ==========
        function updateDocumentTable(callback = null) {
            $.getJSON('/api/documents', function(data) {
                documentTable.clear();

                totalIsThereTrue = 0;
                totalIsThereFalse = 0;

                data.forEach((document) => {
                    let rowNode = documentTable.row.add([
                        document.is_there ? ' <strong>FOUND</strong>' : '<strong>MISSING</strong>',
                        document.rfid_number,
                        document.cif,
                        document.nik_nasabah,
                        document.rekening_nasabah,
                        document.nama_nasabah,
                        document.cabang,
                        document.no_dokumen,
                        document.segmen,
                        document.pinjaman,
                        document.room,
                        document.row,
                        document.rack,
                        document.box
                    ]).node();

                    if (document.is_there) {
                        totalIsThereTrue++;
                        $(rowNode).addClass('bg-success-2');
                    } else {
                        totalIsThereFalse++;
                        $(rowNode).addClass('bg-danger-2');
                    }
                });
                documentTable.draw();
                updateTotalDisplay();
                if (callback) callback();
            });
        }

        function updateRFIDTable(event) {
            rfidtable.clear();
            event.scannedTags.forEach((rfid) => {
                rfidtable.row.add({
                    rfid_number: rfid,
                    timestamp: new Date().toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    })
                });
            });
            rfidtable.draw();
        }

        // Fungsi untuk update tampilan total
        function updateTotalDisplay() {
            $('#totalRFID').text(totalRFID);
            $('#totalIsThereTrue').text(totalIsThereTrue);
            $('#totalIsThereFalse').text(totalIsThereFalse);
        }

        // Panggil pertama kali saat halaman dimuat
        updateDocumentTable();
    </script>
@endpush
