<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'max_participants',
        'status',
        'start_date',
        'end_date',
        'user_id'
    ];


    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }


}
