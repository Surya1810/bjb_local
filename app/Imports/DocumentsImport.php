<?php

namespace App\Imports;

use App\Models\Document;
use App\Models\Agunan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DocumentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $rfid_document = $row['rfid_number']; // RFID Dokumen

        // Simpan data ke tabel Document
        $document = Document::create([
            'rfid_number'       => $rfid_document,
            'cif'               => $row['cif'],
            'nik_nasabah'       => $row['nik_nasabah'],
            'nama_nasabah'      => $row['nama_nasabah'],
            'alamat_nasabah'    => $row['alamat_nasabah'],
            'telp_nasabah'      => $row['telp_nasabah'],
            'pekerjaan_nasabah' => $row['pekerjaan_nasabah'],
            'rekening_nasabah'  => $row['rekening_nasabah'],
            'instansi'          => $row['instansi'],
            'no_dokumen'        => $row['no_dokumen'],
            'segmen'            => $row['segmen'],
            'cabang'            => $row['cabang'],
            'akad'              => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['akad']),
            'jatuh_tempo'       => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['jatuh_tempo']),
            'lama'              => $row['lama'],
            'pinjaman'          => $row['pinjaman'],
            'room'              => $row['room'],
            'row'               => $row['row'],
            'rack'              => $row['rack'],
            'box'               => $row['box'],
            'status'            => $row['status'] ?? null,
            'desc'              => $row['desc'] ?? null,
            'is_there'          => $row['is_there'] ?? true,
        ]);

        // Simpan data agunan
        $agunans = [];
        for ($i = 0; $i < 10; $i++) { // Asumsikan maksimal ada 10 agunan
            if (!empty($row["agunans_{$i}_rfid_number"])) {
                $agunans[] = [
                    'document_id' => $document->id,
                    'rfid_number' => $row["agunans_{$i}_rfid_number"],
                    'name'        => $row["agunans_{$i}_name"] ?? '',
                    'number'      => $row["agunans_{$i}_number"] ?? '',
                ];
            }
        }

        Agunan::insert($agunans);

        return $document;
    }
}
