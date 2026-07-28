<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beo extends Model
{
    protected $table = 'beos';
    protected $fillable = [
        'client_beo_id',
        'user_id',
        'event_number',
        'date_of_function',
        'guaranteed',
        'expected',
        'setup_arrangements',
        'payment_information',
        'note',
        'other_note',
        'signed',
    ]; 
    public function client()
    {
        return $this->belongsTo(ClientBeo::class, 'client_beo_id');
    } 
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    } 
    public function beoApprovals()
    {
        return $this->hasMany(BeoApproval::class,'beo_id');
    }
    public function beoFunctions()
    {
        return $this->hasMany(BeoFunction::class,'beo_id')->orderBy('sort');
    }
    public function beoFunctionPackages()
    {
        return $this->hasMany(BeoFunctionPackage::class,'beo_id');
    }
    public function beoPackages()
    {
        return $this->hasMany(BeoPackage::class,'beo_id');
    }
    public function additionalBreakdowns()
    {
        return $this->hasMany(AdditionalBreakdown::class,'beo_id');
    }
    public function beoAmendments()
    {
        return $this->hasMany(BeoAmendment::class, 'beo_id');
    }

    protected static function booted(): void
    {
        static::created(function (Beo $beo) {
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

                if ($approver && ! in_array($approver->id, $userIds, true)) {
                    $userIds[] = $approver->id;
                }
            }

            foreach ($userIds as $userId) {
                BeoApproval::create([
                    'beo_id' => $beo->id,
                    'user_id' => $userId,
                    'is_verify' => 0,
                ]);
            }
        });

        static::saved(function (Beo $beo) {
            if ($beo->beoApprovals()->doesntExist()) {
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
                    BeoApproval::create([
                        'beo_id' => $beo->id,
                        'user_id' => $userId,
                        'is_verify' => 0,
                    ]);
                }
            }
        });
    }
}
