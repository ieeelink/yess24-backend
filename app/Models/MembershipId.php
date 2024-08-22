<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MembershipId extends Model
{
    use HasFactory;

    public function registrant(): BelongsTo
    {
        return $this->belongsTo(Registrant::class);
    }
}
