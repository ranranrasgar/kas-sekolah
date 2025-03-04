<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JournalEntry extends Model
{
    use HasFactory;
    protected $fillable = ['journal_id', 'coa_id', 'debit', 'credit', 'created_at', 'updated_at'];

    public function coa()
    {
        return $this->belongsTo(Coa::class, 'coa_id');
    }

    public function journal()
    {
        return $this->belongsTo(Journal::class, 'journal_id');
    }
}
