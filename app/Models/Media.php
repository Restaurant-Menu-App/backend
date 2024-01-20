<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $table = 'medias';

    protected $guarded = [];

    public function menus()
    {
        return $this->morphedByMany(Media::class, 'mediabble');
    }
    
    // scope function
    public function scopeIsType($query, $type)
    {
        $query->where('type', $type);
    }
}
