<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'name'
    ];

    public function films(): HasMany
    {
        return $this->hasMany('App\Models\Film');
    }
}
