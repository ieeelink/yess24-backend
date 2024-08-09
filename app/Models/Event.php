<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    public function registrants(): BelongsToMany
    {
        return $this->belongsToMany(Registrant::class);
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }
}
