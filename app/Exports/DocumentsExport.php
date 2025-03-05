<?php

namespace App\Exports;

use App\Models\Document;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DocumentsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Document::select(
            'rfid_number',
            'cif',
            'nik_nasabah',
            'nama_nasabah',
            'alamat_nasabah',
            'telp_nasabah',
            'pekerjaan_nasabah',
            'rekening_nasabah',
            'instansi',
            'no_dokumen',
            'segmen',
            'cabang',
            'akad',
            'jatuh_tempo',
            'lama',
            'pinjaman',
            'room',
            'row',
            'rack',
            'box',
            'status',
            'desc',
            'is_there'
        )->get();
    }

    public function headings(): array
    {
        return [
            'RFID Number',
            'CIF',
            'NIK Nasabah',
            'Nama Nasabah',
            'Alamat Nasabah',
            'Telp Nasabah',
            'Pekerjaan Nasabah',
            'Rekening Nasabah',
            'Instansi',
            'No Dokumen',
            'Segmen',
            'Cabang',
            'Akad',
            'Jatuh Tempo',
            'Lama',
            'Pinjaman',
            'Room',
            'Row',
            'Rack',
            'Box',
            'Status',
            'Deskripsi',
            'Is There'
        ];
    }
}
