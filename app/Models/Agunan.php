<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Agunan extends Model
{
    protected $fillable = ['rfid_number', 'document_id', 'name', 'number'];

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id', 'id'); // Perbaikan relasi
    }

    protected static function boot()
    {
        parent::boot();

        // Event: Saat data dibuat
        static::created(function ($agunan) {
            ChangeHistory::create([
                'entity_type' => 'agunan',
                'no_dokumen' => $agunan->document ? $agunan->document->no_dokumen : 'Tidak ada dokumen',
                'user_id' => Auth::user()->id,
                'changes' => json_encode(['status' => 'Data agunan telah ditambahkan'], JSON_PRETTY_PRINT),
            ]);
        });

        // Event: Saat data diperbarui
        static::updated(function ($agunan) {
            $original = $agunan->getOriginal();
            $changes = $agunan->getChanges();
            $formattedChanges = [];

            foreach ($changes as $key => $newValue) {
                $oldValue = $original[$key] ?? 'kosong';
                $formattedChanges[$key] = "diubah dari '$oldValue' menjadi '$newValue'";
            }

            ChangeHistory::create([
                'entity_type' => 'agunan',
                'no_dokumen' => $agunan->document ? $agunan->document->no_dokumen : 'Tidak ada dokumen',
                'user_id' => Auth::user()->id,
                'changes' => json_encode([
                    'status' => 'Data telah diedit',
                    'changes' => $formattedChanges,
                ], JSON_PRETTY_PRINT),
            ]);
        });

        // Event: Saat data dihapus
        static::deleted(function ($agunan) {
            ChangeHistory::create([
                'entity_type' => 'agunan',
                'no_dokumen' => $agunan->document ? $agunan->document->no_dokumen : 'Tidak ada dokumen',
                'user_id' => Auth::user()->id,
                'changes' => json_encode([
                    'status' => 'Data telah dihapus',
                    'deleted_at' => now(),
                ], JSON_PRETTY_PRINT),
            ]);
        });
    }
}
