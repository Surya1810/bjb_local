<?php

namespace App\Imports;

use App\Models\Agunan;
use App\Models\Document;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AgunansImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Cari document_id berdasarkan kode dokumen dari Excel
        $document = Document::where('no_dokumen', $row['nomor_dokumen'])->first();

        if (!$document) {
            return null; // Lewati baris jika dokumen tidak ditemukan
        }

        return new Agunan([
            'document_id' => $document->id, // Simpan ID dokumen yang sesuai
            'rfid_number' => $row['rfid_number'],
            'name' => $row['nama_agunan'],
            'number' => $row['nomor_agunan'],
        ]);
    }
}
