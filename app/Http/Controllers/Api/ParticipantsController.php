<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ParticipantsResource;
use App\Models\Tournament;
use App\Models\User;
use App\Notifications\ParticipantJoined;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParticipantsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show', 'update', 'destroy']);


    }



    public function index(Tournament $tournament)
    {
        $participants = $tournament->participants()->latest();

        return ParticipantsResource::collection(
            $participants->paginate()
        );

    }

    public function store(Request $request, Tournament $tournament)
    {


        $user = auth()->user();


        if($tournament->participants()->count() >= $tournament->max_participants)
        {
            return response()->json([
                'message' => "Can't join this tournament ",
            ]);
        }

        if($user->is_admin && $tournament->user_id == $user->id )
        {
            return response()->json([
                'message' => "You can't join your own tournament",
            ]);
        }

        $participant = $request->user()->id;
        $tournament->participants()->attach($participant);

        $admin = $request->tournament->User()->id;

        $admin->notify(
            new ParticipantJoined($tournament)
        );

    }


    /*

        detach method detaching all users instead of detaching the only given user

    */
    public function destroy(Request $request,Tournament $tournament,User $user)
    {
        if($tournament->status == 'started')
        {
            return response()->json([
                'message' => "Can't leave the tournament already started.",
            ]);
        }

        $participant = $request->user()->id;

        $tournament->participants()->detach($participant);


        return response()->json([
            'message' => "You have left the tournament."
        ]);
    }
}
