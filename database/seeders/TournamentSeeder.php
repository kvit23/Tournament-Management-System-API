<?php

namespace Database\Seeders;

use App\Models\Tournament;
use App\Models\User;
use Database\Factories\TournamentFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TournamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Tournament::Factory(20)->create()->each(function ($tournament) {
            // Attach random participants to each tournament
            $participants = User::inRandomOrder()->take(rand(5, 20))->pluck('id');
            $tournament->participants()->attach($participants);
        });

    }
}
