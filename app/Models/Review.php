<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function review_replies(): HasMany
    {
        return $this->hasMany(ReviewReply::class);
    }


}
