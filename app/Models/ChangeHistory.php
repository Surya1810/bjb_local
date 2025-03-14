<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChangeHistory extends Model
{
    protected $table = 'change_history';
    protected $fillable = [
        'entity_type',
        'no_dokumen',
        'user_id',
        'changes',
    ];
    protected $casts = [
        'changes' => 'array',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
