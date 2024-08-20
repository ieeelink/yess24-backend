<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\GroupMember;
use App\Models\Registrant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\False_;
use phpDocumentor\Reflection\Types\Void_;

class MentoringSessionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Event $event): JsonResponse
    {
        $validated = $request->validate([
            'registrant_count' => 'required|integer|min:1',
            'registrant_array' => 'required|array|min:1',
        ]);

        if($event->slot < $validated['registrant_count']) {
            return response()->json([
                'message' => 'The allotted slot have been reached'
            ], 405);
        }

        if(count($validated['registrant_array']) == 0)
        {
            return response()->json([
                'message' => 'The registrants array must have at least one registrant'
            ], 405);
        }

        $count = count($validated['registrant_array']);


        if($count == 1)
        {
            $res = $this->add_one_participant($validated['registrant_array'][0], $event);
            if($res)
            {
                if(get_class($res) == "Illuminate\Http\JsonResponse")
                {
                    return $res;
                }
            }
        }

        if($count != 1)
        {
            $res = $this->add_many_participant($validated['registrant_array'], $event);
            if($res)
            {
                if(get_class($res) == "Illuminate\Http\JsonResponse")
                {
                    return $res;
                }
            }

        }

        return response()->json([
            'message' => 'The registrants added to mentoring session'
        ],201);
    }

    private function add_one_participant($email, $event): JsonResponse|bool
    {
        $registrant = Registrant::query()->where('email', $email)->first();

        if($registrant == null)
        {
            return response()->json([
               "message" => "The registrant not found, enter your registered email address"
            ], 405);
        }

        $registrant->event($event);

        $event->slot--;
        $event->save();

        return false;
    }

    public function add_many_participant($registrant_array, $event): JsonResponse|bool
    {
        DB::beginTransaction();
        // Create a Group
        try {

            $group = $event->groups()->create();

            foreach ($registrant_array as $email)
            {
                $registrant = Registrant::query()->where('email', $email)->first();

                // Add Event to Event Registrant Table
                $registrant->event($event);

                $event->slot--;
                $event->save();

                // Making Participant
                $group_members = GroupMember::create([
                    'registrant_id' => $registrant->id,
                    'group_id' => $group->id,
                ]);
            }

            DB::commit();
        } catch (\Exception $exception)
        {
            DB::rollBack();
            return response()->json([
                "message" => $exception->getLine() == 88 ? "Registrant Not Found" : $exception->getMessage()
            ], 405);
        }

        return false;
    }
}
