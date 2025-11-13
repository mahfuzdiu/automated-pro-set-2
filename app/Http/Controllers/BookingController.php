<?php

namespace App\Http\Controllers;

use App\Exceptions\NotEnoughTicketsException;
use App\Http\Requests\BookingStoreRequest;
use App\Jobs\SendBookingConfirmationEmail;
use App\Models\Booking;
use App\Models\Ticket;
use App\Services\BookingService;
use App\Enums\BookingStatusEnum;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public BookingService $bookingService;

    /**
     * BookingController constructor.
     * @param BookingService $bookingService
     */
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return \response()->json(Booking::query()->paginate(10));
    }

    /**
     * @param $bookingId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($bookingId)
    {
        try {
            $booking = Booking::query()->isPending()->findOrFail($bookingId);
            $booking->update(['status' => BookingStatusEnum::CONFIRMED->value]);
            SendBookingConfirmationEmail::dispatch(auth()->user()->name, auth()->user()->email);
            return response()->json(['message' => __('messages.booking.confirmed')]);
        } catch (\Exception $e) {
            return response()->json(['message' => __('messages.booking.not_found')], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param BookingStoreRequest $request
     * @param BookingService $bookingService
     * @param $ticketId
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BookingStoreRequest $request, $ticketId)
    {
        try {
            $validated = $request->validated();
            $ticket = Ticket::findOrFail($ticketId);

            $validated['user_id'] = auth()->user()->id;
            $validated['ticket_id'] = $ticket->id;
            $validated['status'] = BookingStatusEnum::PENDING->value;

            if (!$this->bookingService->checkTicketAvailability($ticket->quantity, $validated['quantity'])) {
                throw new NotEnoughTicketsException();
            }

            $booking = DB::transaction(function () use ($validated, $ticket) {
                $booking = Booking::create($validated);
                $ticket->update([
                    'quantity' => $this->bookingService->decrementTicketQuantity($ticket->quantity, $validated['quantity'])
                ]);
                return $booking;
            });

            return $booking;

        } catch (NotEnoughTicketsException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return response()->json(['message' => __('messages.ticket.not_found')], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param $bookingId
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel($bookingId)
    {
        try {
            $booking = Booking::with('ticket')->findOrFail($bookingId);
            $booking->update(['status' => BookingStatusEnum::CANCELLED->value]);

            $ticket = Ticket::findOrFail($booking->ticket->id);
            $ticket->update(['quantity' => $this->bookingService->incrementTicketQuantity($ticket->quantity, $booking->quantity)]);

            return \response()->json($booking);
        } catch (\Exception $e) {
            return \response()->json(['message' => __('messages.booking.not_found')], Response::HTTP_NOT_FOUND);
        }
    }
}
