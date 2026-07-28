<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeoAmendment extends Model
{
    protected $table = 'beo_amendments';
    protected $fillable = [
        'beo_id',
        'name_of_event',
        'contact_person',
        'contact',
        'date_change',
        'other_before',
        'other_after',
    ];
    public function beo()
    {
        return $this->belongsTo(Beo::class, 'beo_id');
    }
    public function beoAmendmentPackages()
    {
        return $this->hasMany(BeoAmendmentPackage::class, 'beo_amendment_id');
    }
    public function beoAmendmentApprovals()
    {
        return $this->hasMany(BeoAmendmentApproval::class, 'beo_amendment_id');
    }
    public function amendmentBreakdowns()
    {
        return $this->hasMany(AmendmentBreakdown::class, 'beo_amendment_id');
    }
    protected static function booted(): void
    {
        static::created(function (BeoAmendment $beoAmendment) {
            $userIds = [];

            $beoUser = Beo::find($beoAmendment->beo_id);
            $userIds[] = $beoUser->user_id;

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
                BeoAmendmentApproval::create([
                    'beo_amendment_id' => $beoAmendment->id,
                    'user_id' => $userId,
                    'is_verify' => 0,
                ]);
            }
        });

        static::saved(function (BeoAmendment $beoAmendment) {
            if ($beoAmendment->beoAmendmentApprovals()->doesntExist()) {
                $userIds = [];

                $beoUser = Beo::find($beoAmendment->beo_id);
                $userIds[] = $beoUser->user_id;

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
                    BeoAmendmentApproval::create([
                        'beo_amendment_id' => $beoAmendment->id,
                        'user_id' => $userId,
                        'is_verify' => 0,
                    ]);
                }
            }
        });
    }
}