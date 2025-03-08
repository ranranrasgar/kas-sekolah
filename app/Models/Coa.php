<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\JournalEntry;

class Coa extends Model
{
    use HasFactory;
    protected $fillable = ['coa_type_id', 'code', 'name', 'parent_code', 'parent_id', 'created_by', 'updated_by'];
    // protected $guarded = [];
    public function coaType()
    {
        return $this->belongsTo(CoaType::class, 'coa_type_id');
    }

    public function journalEntries()
    {
        return $this->hasMany(JournalEntry::class, 'coa_id');
    }

    public function journalCategory()
    {
        return $this->hasOne(JournalCategory::class, 'coa_id');
    }

    // Relasi ke COA induk
    public function parent()
    {
        return $this->belongsTo(Coa::class, 'parent_id');
    }

    // Relasi ke COA anak
    public function children()
    {
        return $this->hasMany(Coa::class, 'parent_id')
            ->whereColumn('id', '!=', 'parent_id') // Hindari infinite loop
            ->with('children');
    }

    public function isRoot()
    {
        return $this->id == $this->parent_id;
    }

    public function level()
    {
        $level = 0;
        $parent = $this->parent;

        while ($parent) {
            $level++;
            $parent = $parent->parent;
        }

        return $level;
    }

    // public function children()
    // {
    //     return $this->hasMany(Coa::class, 'parent_id');
    // }
}
