@extends('layouts.admin')

@section('title', 'Changes History')

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/adminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/adminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <style>
        .card-outline {
            border-radius: 10px;
        }

        .total-container {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
@endpush

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Change History</h1>
                    <ol class="breadcrumb text-black-50">
                        <li class="breadcrumb-item"><a class="text-black-50" href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active"><strong>Change History</strong></li>
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
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Change History List</h3>
                        </div>
                        <div class="card-body table-responsive">
                            <table id="changeHistoryTable" class="table table-bordered table-hover text-center w-100">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Jenis</th>
                                        <th>Dokumen</th>
                                        <th>Diubah Oleh</th>
                                        <th>Perubahan</th>
                                        <th>Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($changeHistory as $history)
                                        <tr>
                                            <td>{{ ucfirst($history->entity_type) }}</td>
                                            <td>{{ $history->no_dokumen }}</td>
                                            <td>{{ $history->user_name }}</td>
                                            <td class="text-left">
                                                @php
                                                    $changes = json_decode($history->changes, true);
                                                    $action = is_array($changes)
                                                        ? $changes['status'] ?? 'Perubahan tidak dikenali'
                                                        : $changes;
                                                    $detailChanges = $changes['changes'] ?? [];

                                                    // Mapping nama kolom untuk Document & Agunan
                                                    $fieldNames = [
                                                        // Mapping untuk Agunan
                                                        'number' => 'Nomor Agunan',
                                                        'name' => 'Nama Agunan',
                                                        'rfid_number' => 'Nomor RFID',

                                                        // Mapping untuk Document
                                                        'cif' => 'CIF',
                                                        'nik' => 'NIK Nasabah',
                                                        'nama_nasabah' => 'Nama Nasabah',
                                                        'alamat_nasabah' => 'Alamat Nasabah',
                                                        'telp_nasabah' => 'Telepon Nasabah',
                                                        'pekerjaan_nasabah' => 'Pekerjaan Nasabah',
                                                        'rekening_nasabah' => 'Rekening Nasabah',
                                                        'instansi' => 'Instansi',
                                                        'no_dokumen' => 'Nomor Dokumen',
                                                        'segmen' => 'Segmen',
                                                        'cabang' => 'Cabang',
                                                        'akad' => 'Tanggal Akad',
                                                        'jatuh_tempo' => 'Tanggal Jatuh Tempo',
                                                        'pinjaman' => 'Jumlah Pinjaman',
                                                        'room' => 'Ruangan',
                                                        'row' => 'Baris',
                                                        'rack' => 'Rak',
                                                        'box' => 'Box',
                                                    ];
                                                @endphp

                                                @if (str_contains($action, 'Data dipinjam oleh'))
                                                    <em>{{ $action }}</em>
                                                @else
                                                    <em>{{ $action }}</em>

                                                    @if ($action == 'Data telah diedit' && !empty($detailChanges))
                                                        <ul class="mb-0">
                                                            @foreach ($detailChanges as $key => $value)
                                                                @if ($key !== 'updated_at')
                                                                    {{-- Jangan tampilkan updated_at --}}
                                                                    @php
                                                                        $fieldLabel =
                                                                            $fieldNames[$key] ??
                                                                            ucfirst(str_replace('_', ' ', $key));
                                                                    @endphp
                                                                    <li><em>{{ $fieldLabel }}: {{ $value }}</em>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>{{ $history->created_at }}</td>
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
@endsection

@push('scripts')
    <!-- DataTables & Plugins -->
    <script src="{{ asset('assets/adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/adminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/adminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/adminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#changeHistoryTable').DataTable({
                "paging": true,
                'processing': true,
                "searching": true,
                "info": true,
                "scrollX": true,
                "order": [],
            });
        });
    </script>
@endpush
