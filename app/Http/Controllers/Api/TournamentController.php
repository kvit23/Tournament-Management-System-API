<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TournamentResource;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);

        $this->middleware('is_admin')->except('index','show');

    }



    public function index()
    {

        $tournament = Tournament::query();

        $tournament->when(request('search'), function($query){
            $query->where('name', 'like', '%'. request('search') .'%')
            ->orWhere('status', 'like', '%' . request('search') . '%')
            ->orWhere('start_date', 'like', '%' . request('search') . '%');
        });

        return TournamentResource::collection($tournament->get());
    }



    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:225',
            'description' => 'required|string',
            'max_participants' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $validatedData['user_id'] = $request->user()->id;

        $tournament = Tournament::create($validatedData);

        return new TournamentResource($tournament);

    }


    public function show(Tournament $tournament)
    {
        return new TournamentResource($tournament);
    }


    public function update(Request $request, Tournament $tournament)
    {
        $tournament->update(
            $request->validate([
                'name' => 'sometimes|string|max:225',
                'description' => 'nullable|string',
                'max_participants' => 'sometimes|',
                'status' => 'required',
                'start_date' => 'sometimes|date',
                'end_date' => 'sometimes|date|after:start_date'
            ])
        );

        return new TournamentResource($tournament);
    }



    public function destroy(Tournament $tournament)
    {
           $tournament->delete();

           return response(status: 204);
    }

}
