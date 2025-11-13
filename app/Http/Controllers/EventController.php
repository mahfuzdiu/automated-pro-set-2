<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Http\Requests\EventStoreRequest;
use App\Models\Event;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class EventController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @param EventRequest $request
     */
    public function index(EventRequest $request)
    {
        $validated = $request->validated();
        $search = $validated['search'] ?? '';
        $date = $validated['date'] ?? '';
        $page = $validated['page'] ?? 1;

        $cacheKey = "events_page_{$page}_search_{$search}_date_{$date}";

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($search, $date) {
            return Event::query()
                ->searchByTitle($search)
                ->filterByDate($date)
                ->paginate(20);
        });
    }


    /**
     * Store a newly created resource in storage.
     * @param EventStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(EventStoreRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = auth()->user()->id;
        $event = Event::create($validated);
        return response()->json($event);
    }

    /**
     * Display the specified resource.
     * @param Event $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Event $event)
    {
        return response()->json($event);
    }

    /**
     * Update the specified resource in storage.
     * @param EventStoreRequest $request
     * @param Event $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(EventStoreRequest $request, Event $event)
    {
        $this->authorize('update', $event);
        $event->update($request->validated());
        return response()->json($event);
    }

    /**
     * Remove the specified resource from storage.
     * @param Event $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        if ($event->tickets()->exists()) {
            return response()->json([
                'message' => __('messages.event.cannot_be_deleted')
            ], Response::HTTP_BAD_REQUEST);
        }
        $event->delete();
        return response()->json(['message' => __('messages.event.deleted')]);
    }
}
