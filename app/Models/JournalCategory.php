<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalCategory extends Model
{
    /** @use HasFactory<\Database\Factories\JournalCategoyFactory> */
    use HasFactory;
    protected $guarded = [];

    public function journals()
    {
        return $this->hasMany(Journal::class, 'category_id');
    }

    public function coa()
    {
        return $this->belongsTo(coa::class, 'coa_id');
    }
}
