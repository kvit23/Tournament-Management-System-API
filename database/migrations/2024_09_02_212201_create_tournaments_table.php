<?php

use App\Models\Games;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id()->autoIncrement;

            $table->string('name');
            $table->text('description');
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Games::class);
            $table->integer('max_participants');
            $table->enum('status', ['upcoming', 'started', 'finished'])->default('upcoming');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->foreignId('winner_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
