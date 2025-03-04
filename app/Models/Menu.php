<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['parent_id', 'name', 'route', 'category_id', 'icon', 'ordering'];

    public function submenus()
    {
        // return $this->hasMany(Menu::class, 'parent_id');
        return $this->hasMany(Menu::class, 'parent_id')->with('subsubmenus')->orderBy('ordering');
    }

    public function subsubmenus()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('ordering');
    }
}
