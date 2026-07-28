<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeoWedding extends Model
{
    protected $table = 'beo_weddings';
    protected $fillable = [
        'client_wedding_id',
        'user_id',
        'event_number',
        'date_of_function',
        'guaranteed',
        'expected',
        'setup_arrangements',
        'protocol',
        'payment_information',
        'payment_note',
        'other_note',
        'note',
        'signed',
        'menu_list',
        'deposit',
        'banquet',
    ];
    public function client()
    {
        return $this->belongsTo(ClientWedding::class, 'client_wedding_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function beoWeddingFunctions()
    {
        return $this->hasMany(BeoWeddingFunction::class, 'beo_wedding_id');
    }
    public function beoWeddingPackages()
    {
        return $this->hasMany(BeoWeddingPackage::class, 'beo_wedding_id');
    }
    public function beoWeddingApprovals()
    {
        return $this->hasMany(BeoWeddingApproval::class, 'beo_wedding_id');
    }
    public function beoWeddingBreakdownPostings()
    {
        return $this->hasMany(BeoWeddingBreakdownPosting::class, 'beo_wedding_id');
    }
    public function beoWeddingMakeUps()
    {
        return $this->hasMany(BeoWeddingMakeUp::class, 'beo_wedding_id');
    }
    public function weddingMakeUps()
    {
        return $this->belongsToMany(Venue::class, 'beo_wedding_make_ups', 'beo_wedding_id', 'venue_id');
    }

    public function venues()
    {
        return $this->belongsToMany(Venue::class, 'beo_wedding_make_ups', 'beo_wedding_id', 'venue_id');
    }
    protected static function booted(): void
    {
        static::created(function (BeoWedding $beo) {
            $userIds = [];

            if (filled($beo->user_id)) {
                $userIds[] = $beo->user_id;
            }

            foreach (Position::query()->orderBy('signature_positions')->get() as $position) {
                $approver = \App\Models\User::query()
                    ->where('position_id', $position->id)
                    ->where('is_active', 1)
                    ->whereHas('roles', function ($q) {
                        $q->where('name', 'approver');
                    })
                    ->first();

                if ($approver && !in_array($approver->id, $userIds, true)) {
                    $userIds[] = $approver->id;
                }
            }

            foreach ($userIds as $userId) {
                BeoWeddingApproval::create([
                    'beo_wedding_id' => $beo->id,
                    'user_id' => $userId,
                    'is_verify' => 0,
                ]);
            }
        });

        static::saved(function (BeoWedding $beo) {
            if ($beo->beoWeddingApprovals()->doesntExist()) {
                $userIds = [];

                if (filled($beo->user_id)) {
                    $userIds[] = $beo->user_id;
                }

                foreach (Position::query()->orderBy('signature_positions')->get() as $position) {
                    $approver = \App\Models\User::query()
                        ->where('position_id', $position->id)
                        ->where('is_active', 1)
                        ->whereHas('roles', function ($q) {
                            $q->where('name', 'approver');
                        })
                        ->first();

                    if ($approver && !in_array($approver->id, $userIds, true)) {
                        $userIds[] = $approver->id;
                    }
                }

                foreach ($userIds as $userId) {
                    BeoWeddingApproval::create([
                        'beo_wedding_id' => $beo->id,
                        'user_id' => $userId,
                        'is_verify' => 0,
                    ]);
                }
            }
        });
    }
}
