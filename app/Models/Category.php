<?php

namespace App\Models;

// 1. Debes importar la clase HasFactory
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // 2. Debes incluir el trait dentro de la clase
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'icon'];

    public function apps()
    {
        return $this->hasMany(AppService::class);
    }
}
