<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use  HasFactory;
    // protected $fillable = ["nisn", "name", "email", "phone", "address", "major_id", "class_id", "agama_id", "birth_date", "student_photo"];
    //yang tidak boleh di isi [] kosong artinya semunya boleh
    protected $guarded = [];

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }
    public function class()
    {
        return $this->belongsTo(Classe::class, 'class_id');
    }
    public function agama()
    {
        return $this->belongsTo(Agama::class, 'agama_id');
    }
}
