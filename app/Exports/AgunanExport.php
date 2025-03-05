<?php

namespace App\Exports;

use App\Models\Agunan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AgunanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Agunan::select(
            'document_id',
            'rfid_number',
            'name',
            'number'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Document ID',
            'RFID Number',
            'Nama Agunan',
            'Nomor Agunan'
        ];
    }
}
