<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TournamentResource;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');

        $this->middleware('is_admin');

    }
    public function index()
    {
        $tournament =  Tournament::query();
        return TournamentResource::collection(
            Tournament::where('user_id', Auth::user()->id)
            ->orderBy('id')->paginate(5));
    }



}
