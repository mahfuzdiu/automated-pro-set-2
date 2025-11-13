<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketStoreRequest;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Response;

class TicketController extends Controller
{
    use AuthorizesRequests;

    /**
     * Store a newly created resource in storage.
     * @param TicketStoreRequest $request
     */
    public function store(TicketStoreRequest $request, $eventId)
    {
        try {
            $event = Event::findOrFail($eventId);
            $validated = $request->validated();
            $validated['event_id'] = $event->id;
            $validated['created_by'] = auth()->user()->id;
            $ticket = Ticket::create($validated);
            return response()->json($ticket);
        } catch (\Exception $e) {
            return response()->json([
                'message' => __('messages.event.not_found'),
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param TicketStoreRequest $request
     * @param Ticket $ticket
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TicketStoreRequest $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);
        $ticket->update($request->validated());
        return response()->json($ticket);
    }

    /**
     * Remove the specified resource from storage.
     * @param Ticket $ticket
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Ticket $ticket)
    {
        $this->authorize('delete', $ticket);
        if ($ticket->bookings()->exists()) {
            return response()->json([
                'message' => __('messages.ticket.cannot_be_deleted')
            ], Response::HTTP_BAD_REQUEST);
        }

        $ticket->delete();
        return response()->json([
            'message' => __('messages.ticket.deleted')
        ]);
    }
}
