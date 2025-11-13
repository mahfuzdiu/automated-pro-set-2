<?php

namespace App\Traits;

use App\Enums\BookingStatusEnum;
use Illuminate\Database\Eloquent\Builder;

use function Illuminate\Database\Query\orWhere;

trait BookingTrait
{
    /**
     * @return bool
     */
    public function scopeConfirmedOrPending($query): Builder
    {
        return $query->where('status', BookingStatusEnum::PENDING->value)->orWhere('status', BookingStatusEnum::CONFIRMED->value);
    }

    public function scopeIsPending($query): Builder
    {
        return $query->where('status', BookingStatusEnum::PENDING->value);
    }

    public function isPending(): bool
    {
        return $this->status == BookingStatusEnum::PENDING->value;
    }
}
