<?php

namespace App\Models;

use App\Utils\Certificate;
use Exception;
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


    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }

    /**
     * @throws Exception
     */
    public function event($event)
    {
        $registrants_events = $this->events;
        foreach ($registrants_events as $registrants_event)
        {
            if ($registrants_event->type === $event->type)
            {
                throw new Exception($this->name . ' already registered for ' . $registrants_event->type);
            }
        }
        $this->events()->attach($event);
    }

    public function group_member(): HasOne
    {
        return $this->hasOne(GroupMember::class);
    }

    public function checks()
    {
        return $this->hasOne(Check::class);
    }

    public function isValidated()
    {
        return $this->checks->isValidated;
    }

    public function isAttending()
    {
        return $this->checks->isAttending;
    }

    public function certificate()
    {
        return Certificate::generateCertificate($this->name, $this->college_name);
    }
}
