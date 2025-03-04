<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CoaType extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function coas()
    {
        return $this->hasMany(Coa::class, 'coa_type_id');
    }
}
