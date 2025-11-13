<?php

namespace App\Http\Controllers;

use App\Exceptions\BookingNotConfirmedException;
use App\Models\Booking;
use App\Models\Payment;
use App\Services\PaymentService;
use App\Enums\PaymentStatusEnum;
use Illuminate\Http\Response;

class PaymentController extends Controller
{
    public PaymentService $paymentService;

    /**
     * PaymentController constructor.
     * @param PaymentService $paymentService
     */
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * @param $bookingId
     * @return \Illuminate\Http\JsonResponse
     */
    public function makePayment($bookingId)
    {
        try {
            $booking = Booking::with('ticket')->findOrFail($bookingId);
            if ($booking->isPending()) {
                throw new BookingNotConfirmedException();
            }

            Payment::create([
                'booking_id' => $booking->id,
                'amount' => $this->paymentService->calculateTicketPrice($booking->quantity, $booking->ticket->price),//
                'status' => PaymentStatusEnum::SUCCESS->value
            ]);

            return response()->json(['message' => __('messages.payment.success')]);
        } catch (BookingNotConfirmedException $e) {
            return response()->json(['message' => __('messages.payment.failure') . ': ' . __('messages.booking.not_confirmed')], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return response()->json(['message' => __('messages.payment.failure') . ': ' .__('messages.booking.not_found')], Response::HTTP_BAD_REQUEST);
        }
    }
}
