<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Currency extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function entries()
    {
        return $this->hasMany(Journal::class);
    }
}
