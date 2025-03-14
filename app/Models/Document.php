<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Document extends Model
{
    use HasFactory;
    protected $fillable = ['rfid_number', 'cif', 'nik_nasabah', 'nama_nasabah', 'alamat_nasabah', 'telp_nasabah', 'pekerjaan_nasabah', 'rekening_nasabah', 'instansi', 'no_dokumen', 'segmen', 'cabang', 'akad', 'jatuh_tempo', 'lama', 'pinjaman', 'room', 'row', 'rack', 'box', 'status', 'desc', 'is_there'];

    protected $casts = [
        'akad' => 'datetime',
        'jatuh_tempo' => 'datetime'
    ];

    public function tag()
    {
        return $this->belongsTo(tag::class, 'rfid_number');
    }

    public function agunans()
    {
        return $this->hasMany(Agunan::class, 'document_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        // Event: Saat data dibuat
        static::created(function ($document) {
            ChangeHistory::create([
                'entity_type' => 'document',
                'no_dokumen' => $document->no_dokumen,
                'user_id' => Auth::user()->id,
                'changes' => json_encode(['status' => 'Data telah ditambahkan'], JSON_PRETTY_PRINT),
            ]);
        });

        // Event: Saat data diperbarui
        static::updated(function ($document) {
            $original = $document->getOriginal();
            $changes = $document->getChanges();
            $formattedChanges = [];

            foreach ($changes as $key => $newValue) {
                $oldValue = $original[$key] ?? 'kosong';

                // Jika yang diubah adalah status & status baru berisi "Dipinjam oleh"
                if ($key == 'status' && str_contains($newValue, 'Dipinjam oleh')) {
                    $formattedChanges['status'] = $newValue; // Simpan status "Dipinjam oleh ..."
                } else {
                    $formattedChanges[$key] = "diubah dari '$oldValue' menjadi '$newValue'";
                }
            }

            ChangeHistory::create([
                'entity_type' => 'document',
                'no_dokumen' => $document->no_dokumen,
                'user_id' => Auth::user()->id,
                'changes' => json_encode([
                    'status' => 'Data telah diedit',
                    'changes' => $formattedChanges,
                ], JSON_PRETTY_PRINT),
            ]);
        });

        // Event: Saat data dihapus
        static::deleted(function ($document) {
            ChangeHistory::create([
                'entity_type' => 'document',
                'no_dokumen' => $document->no_dokumen,
                'user_id' => Auth::user()->id,
                'changes' => json_encode([
                    'status' => 'Data telah dihapus',
                    'deleted_at' => now(),
                ], JSON_PRETTY_PRINT),
            ]);
        });
    }
}
