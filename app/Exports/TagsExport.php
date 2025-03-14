<?php

namespace App\Exports;

use App\Models\Tag;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TagsExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{


    public function collection()
    {
        return Tag::select('rfid_number', 'status', 'created_at')
            ->get()
            ->map(function ($row) {
                return [
                    'rfid_number' => $row->rfid_number,
                    'status' => $row->status,
                    'created_at' => $row->created_at->format('Y-m-d'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            ["Laporan Data Tag RFID"],
            [
                'RFID Number',
                'Status',
                'Created At',
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
