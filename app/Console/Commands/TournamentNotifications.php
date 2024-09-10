<?php

namespace App\Console\Commands;

use App\Models\Tournament;
use App\Notifications\TournamentReminderNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class TournamentNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:tournament-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reminding participants';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tournaments = Tournament::with('participants')
            ->whereBetween('start_date', [now(), now()->addDay()])->get();
        $tournamentCount = $tournaments->count();
        $tournamentLabel = Str::plural('tournament', $tournamentCount);

        $this->info("Found ${tournamentCount}  ${tournamentLabel}. ");

        $tournaments->each(
            fn ($tournament) => $tournament->participants->each(

                //fn ($participant) => $this->info("notifying {$participant->id} . {$participant->name}")

                fn ($participant) => $participant->notify(
                    new TournamentReminderNotification(
                        $tournament
                    )
                )

            )
        );

        $this->info('Test Test!');
    }
}
