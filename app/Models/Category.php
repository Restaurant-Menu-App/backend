<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use HasFactory, HasSlug;

    protected $guarded = [];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'rests_cats', 'category_id', 'restaurant_id');
    }

    public function scopeIsType($query, $type)
    {
        $query->where('type', $type);
    }

    public function scopeFilterOn($query)
    {
        if (request('name')) {
            $query->where('name', 'like', '%' . request('name') . '%');
        }

        if(request('type')){
            $query->where('type', request('type'));
        }
    }
}
