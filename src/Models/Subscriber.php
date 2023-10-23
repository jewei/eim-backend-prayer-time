<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscriber extends Model
{
    use HasFactory;

    /**
     * @var array<string>|bool
     */
    protected $guarded = [];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
