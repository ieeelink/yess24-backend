<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens;

class Registrant extends Model
{
    use HasApiTokens, HasFactory;

    public function membership_id(): HasOne
    {
        return $this->hasOne(MembershipId::class);
    }

    public function ticket(): HasOne
    {
        return $this->hasOne(Ticket::class);
    }

    public function details(): HasOne
    {
        return $this->hasOne(Detail::class);
    }

    public function event(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }
}
