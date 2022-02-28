<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticker',
        'name',
        'sector',
        'file_name',
    ];

    public function filename()
    {
        return $this->belongsTo(FileName::class);
    }
}
