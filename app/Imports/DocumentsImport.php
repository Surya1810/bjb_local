<?php

namespace App\Imports;

use App\Models\Document;
use App\Models\Tag;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class DocumentsImport implements ToModel, WithHeadingRow
{
    protected $existingRfids;

    public function __construct()
    {
        $this->existingRfids = Tag::where('status', 'available')->pluck('rfid_number')->toArray();
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (!in_array($row['rfid'], $this->existingRfids)) {
            return null;
        }

        $document = Document::firstOrCreate(
            ['rfid_number' => $row['rfid']], // Unik
            [
                'cif' => $row['cif'],
                'nik_nasabah' => $row['nik'],
                'nama_nasabah' => $row['nama'],
                'alamat_nasabah' => $row['alamat'],
                'telp_nasabah' => $row['telepon'],
                'pekerjaan_nasabah' => $row['pekerjaan'],
                'rekening_nasabah' => $row['rekening'],
                'instansi' => $row['instansi'],

                'no_dokumen' => $row['dokumen'],
                'segmen' => $row['segmen'],
                'cabang' => $row['cabang'],
                'akad' => Date::excelToDateTimeObject($row['akad'])->format('Y-m-d'),
                'jatuh_tempo' => Date::excelToDateTimeObject($row['jatuh_tempo'])->format('Y-m-d'),
                'lama' => $row['lama_pinjaman'],
                'pinjaman' => $row['nilai'],

                'room' => $row['ruangan'],
                'row' => $row['baris'],
                'rack' => $row['rak'],
                'box' => $row['box'],

                'status' => $row['status'] ?? null,
                'desc' => $row['keterangan'] ?? null,
            ]
        );
        Tag::where('rfid_number', $row['rfid'])->update(['status' => 'used']);

        return $document;
    }
}
