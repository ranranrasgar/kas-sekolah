<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Journal extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'reference',
        'description',
        'currency_id',
        'category_id',
        'created_by',
        'updated_by'
    ];

    public function journalEntries()
    {
        return $this->hasMany(JournalEntry::class, 'journal_id');
    }

    public function journalCategory()
    {
        return $this->belongsTo(JournalCategory::class, 'category_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}
