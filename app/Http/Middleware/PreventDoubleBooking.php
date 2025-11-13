<?php

namespace App\Http\Middleware;

use App\Exceptions\ExistingBookingException;
use App\Models\Booking;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventDoubleBooking
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $existing = Booking::where('ticket_id', $request->ticket_id)
            ->where('user_id', auth()->user()->id)
            ->confirmedOrPending()
            ->exists();

        if ($existing) {
            return response()->json([
                'message' => __('messages.booking.exists')
            ], Response::HTTP_CONFLICT);
        }

        return $next($request);
    }
}
