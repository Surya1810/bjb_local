<?php

namespace App\Exports;

use App\Models\Agunan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Carbon\Carbon;

class FoundAgExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Agunan::where('is_there', true) // Hanya mengambil yang ditemukan
            ->select('document_id', 'rfid_number', 'name', 'number')
            ->get();
    }

    public function headings(): array
    {
        $date = Carbon::now()->format('d F Y');
        return [
            ["BERITA ACARA PENEMUAN DOKUMEN"], // Judul laporan
            [""], // Baris kosong
            ["Pada hari ini, {$date}, telah dilakukan pengecekan agunan dengan hasil sebagai berikut:"], // Deskripsi awal
            [""], // Baris kosong sebelum tabel
            ['No Dokumen', 'RFID Number', 'Jenis Agunan', 'Nomor Agunan'] // Header tabel
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Menentukan jumlah data yang akan di-export
        $rowCount = Agunan::where('is_there', true)->count() + 5; // Jumlah data + header

        // Styling judul utama
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ]);

        // Styling deskripsi awal
        $sheet->mergeCells('A3:I3');
        $sheet->getStyle('A3')->applyFromArray([
            'font' => ['italic' => true, 'size' => 12],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true
            ]
        ]);

        // Styling header tabel
        $sheet->getStyle('A5:F5')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D9D9D9'] // Warna abu-abu untuk header tabel
            ],
            'borders' => [
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ]
            ]
        ]);

        // Styling seluruh isi tabel dengan border
        $sheet->getStyle("A5:F{$rowCount}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ]
            ]
        ]);

        // Auto-size kolom agar lebih rapi
        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }
}
