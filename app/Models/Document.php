<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['rfid_number', 'cif', 'nik_nasabah', 'nama_nasabah', 'alamat_nasabah', 'telp_nasabah', 'pekerjaan_nasabah', 'rekening_nasabah', 'instansi', 'no_dokumen', 'segmen', 'cabang', 'akad', 'jatuh_tempo', 'lama', 'pinjaman', 'room', 'row', 'rack', 'box', 'status', 'desc', 'is_there'];

    protected $casts = [
        'akad' => 'datetime',
        'jatuh_tempo' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tag()
    {
        return $this->belongsTo(tag::class, 'rfid_number');
    }

    public function agunans()
    {
        return $this->hasMany(Agunan::class);
    }
}
