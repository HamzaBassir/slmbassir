<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileName extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_name'
    ];

    public function filecontents()
    {
        return $this->hasMany(FileContent::class);
    }
}
