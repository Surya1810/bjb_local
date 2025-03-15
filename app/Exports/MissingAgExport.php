<?php

namespace App\Exports;

use App\Models\Agunan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Carbon\Carbon;

class MissingAgExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Agunan::where('is_there', false) // Hanya mengambil yang hilang
            ->select('document_id', 'rfid_number', 'name', 'number')
            ->get();
    }

    public function headings(): array
    {
        $date = Carbon::now()->translatedFormat('l, d F Y'); // Format tanggal dalam bahasa lokal
        return [
            ["BERITA ACARA KEHILANGAN AGUNAN"], // Judul laporan
            [""], // Baris kosong
            ["Pada hari ini, {$date}, telah dilakukan pengecekan. Berdasarkan hasil pengecekan, ditemukan bahwa agunan berikut ini tidak ditemukan:"], // Deskripsi awal
            [""], // Baris kosong sebelum tabel
            ['Dokumen', 'Nomor RFID', 'Jenis Agunan', 'Nomor Agunan'] // Header tabel
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Menentukan jumlah data yang akan di-export
        $rowCount = Agunan::where('is_there', false)->count() + 5; // Jumlah data + header

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
        $sheet->mergeCells('A3:M3');
        $sheet->getStyle('A3')->applyFromArray([
            'font' => ['italic' => true, 'size' => 12],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true
            ]
        ]);

        // Styling header tabel
        $sheet->getStyle('A5:D5')->applyFromArray([
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
        $sheet->getStyle("A5:D{$rowCount}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ]
            ]
        ]);

        // Auto-size kolom agar lebih rapi
        foreach (range('A', 'D') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }
}
