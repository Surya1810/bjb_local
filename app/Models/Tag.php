<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $primaryKey = 'rfid_number';

    protected $casts = [
        'rfid_number' => 'string',
    ];

    public function document()
    {
        // return $this->hasOne(Asset::class, 'tag_id');
    }
}
