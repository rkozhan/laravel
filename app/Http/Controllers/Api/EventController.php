<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\EventResource;
use Illuminate\Http\JsonResponse;

class EventController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $events = $this->getEventsUpcomingOrAll($request)
            ->orderBy('date', 'asc')
            ->get();

        return $this->sendResponse(EventResource::collection($events), 'Events retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $input = $request->all();

        $validator = $this->validateEvent($request);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input['user_id'] = auth()->id();

        $event = Event::create($input);

        return $this->sendResponse(new EventResource($event), 'Event created successfully.' );
    }

    /**
     * Display the specified resource.
     *
     * @param Event $event
     * @return Response
     */
    public function show(Event $event): Response
    {
        if (!$this->checkUserId($event)) {
            return $this->sendError('Unauthorized.');
        }

        return $this->sendResponse(new EventResource($event), 'Event retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Event $event
     * @return Response
     */
    public function update(Request $request, Event $event): Response
    {
        if (!$this->checkUserId($event)) {
            return $this->sendError('Unauthorized.');
        }

        $input = $request->all();

        $validator = $this->validateEvent($request);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $event->title = $input['title'];
        $event->date = $input['date'];
        $event->save();

        return $this->sendResponse(new EventResource($event), 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Event $event
     * @return Response
     */
    public function destroy(Event $event): Response
    {
        if (!$this->checkUserId($event)) {
            return $this->sendError('Unauthorized.');
        }

        $event->delete();

        return $this->sendResponse([], 'Event deleted successfully.');
    }

    private function validateEvent(Request $request): \Illuminate\Validation\Validator
    {
        return Validator::make($request->all(), [
            'title' => 'required',
            'date' => 'required|date|after_or_equal:' . now(),
        ]);
    }

    private function checkUserId(Event $event): bool
    {
        return $event->user_id == auth()->id();
    }

    private function getEventsUpcomingOrAll(Request $request): \Illuminate\Database\Eloquent\Builder
    {
        if ($request->query('past', 'false') === 'true') return Event::where('user_id', auth()->id());

        return Event::where('user_id', auth()->id())
            ->where('date', '>=', now());
    }
}

