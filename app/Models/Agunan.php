<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agunan extends Model
{
    protected $fillable = ['rfid_number', 'document_id'];

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }
}
