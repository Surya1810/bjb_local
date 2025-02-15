<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['rfid_number', 'user_id'];

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
