<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remarks extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'name',
        'remark',
        'checked',
        'checked_at',
    ];

    protected $casts = [
        'checked_at' => 'datetime',
    ];

    // Requests
    public function requests()
    {
        return $this->belongsTo(Requests::class, 'request_id', 'id');
    }
}
