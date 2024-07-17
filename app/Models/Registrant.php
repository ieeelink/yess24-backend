<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Registrant extends Model
{
    use HasFactory;

    public function membership_id(): HasOne
    {
        return $this->hasOne(MembershipId::class);
    }
}
