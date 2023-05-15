<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stat extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'film_id',
        'score',
        'votes',
    ];

    public function film(): BelongsTo
    {
        return $this->belongsTo('App\Models\Film');
    }
}
