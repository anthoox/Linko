<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppService extends Model
{
    protected $fillable = [
        'name',
        'url',
        'image_path', 
        'category_id',
        'user_id',
        'is_favorite', 
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
