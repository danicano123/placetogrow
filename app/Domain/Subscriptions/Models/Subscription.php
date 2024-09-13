<?php

namespace App\Domain\Subscriptions\Models;

use App\Domain\Microsites\Models\Microsite;
use App\Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'token',
        'subtoken',
        'microsite_id',
    ];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
        return $this->belongsTo(Microsite::class);

    }
}
