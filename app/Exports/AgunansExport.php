<?php

namespace App\Exports;

use App\Models\Agunan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class AgunansExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    public function collection()
    {
        return Agunan::select(
            'document_id',
            'rfid_number',
            'name',
            'number',
        )->with('document:id,no_dokumen') // Mengambil data dari tabel document
            ->get()->map(function ($row) {
                $row->document_id = $row->document ? $row->document->no_dokumen : '-'; // Ganti ID dengan no_dokumen
                return $row;
            });
    }

    public function headings(): array
    {
        return [
            ["Laporan Data Agunan"], // Judul dokumen di baris pertama
            [ // Header tabel di baris kedua
                'No Dokumen',
                'RFID Number',
                'Nama Agunan',
                'Nomor Agunan'
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Styling judul dokumen
        $sheet->mergeCells('A1:D1'); // Menggabungkan sel untuk judul
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ]);

        // Styling header tabel
        $sheet->getStyle('A2:D2')->applyFromArray([
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
        foreach (range('A', 'D') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
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
