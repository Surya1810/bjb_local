<?php

namespace App\Exports;

use App\Models\Document;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\DB;

class DocumentsExport implements FromCollection, WithHeadings, WithStyles, WithEvents
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
        )->get()->map(function ($row) {
            $row->akad = $row->akad ? $row->akad->format('Y-m-d') : null;
            $row->jatuh_tempo = $row->jatuh_tempo ? $row->jatuh_tempo->format('Y-m-d') : null;

            // Format pinjaman ke Rupiah
            $row->pinjaman = 'Rp. ' . number_format($row->pinjaman, 0, ',', '.');

            return $row;
        });
    }





    public function headings(): array
    {
        return [
            ["Laporan Data Dokumen"], // Judul dokumen di baris pertama
            [ // Header tabel di baris kedua
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
                'Jumlah Agunan'
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Styling judul dokumen
        $sheet->mergeCells('A1:W1'); // Menggabungkan sel untuk judul
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ]);

        // Styling header tabel
        $sheet->getStyle('A2:W2')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F81BD'] // Warna biru tua untuk header
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ]);

        // Auto-size column
        foreach (range('A', 'W') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Wrap text untuk alamat agar tidak kepanjangan
        $sheet->getStyle('E:E')->getAlignment()->setWrapText(true);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(25); // Atur tinggi baris judul
            },
        ];
    }
}
