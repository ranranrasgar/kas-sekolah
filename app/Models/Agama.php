<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agama extends Model
{
    use HasFactory;

    protected $fillable = ['name']; // Menyesuaikan dengan kolom 'name'

    // Relasi ke siswa
    public function students()
    {
        return $this->hasMany(Student::class, 'agama_id');
    }
}
