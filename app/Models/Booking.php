<?php

namespace App\Models;

use App\Enums\BookingStatusEnum;
use App\Traits\BookingTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /** @use HasFactory<\Database\Factories\BookingFactory> */
    use HasFactory;
    use BookingTrait;

    protected $fillable = [
        'user_id',
        'ticket_id',
        'quantity',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
