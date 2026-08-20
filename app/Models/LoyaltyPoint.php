<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyPoint extends Model
{
    protected $fillable = [
        'user_id',
        'points',
        'points_earned',
        'points_redeemed',
        'points_balance',
    ];

    public function getPointsEarnedAttribute()
    {
        return $this->attributes['points'] ?? 0;
    }

    public function setPointsEarnedAttribute($value)
    {
        $this->attributes['points'] = $value;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(LoyaltyPointTransaction::class, 'user_id', 'user_id');
    }
}
