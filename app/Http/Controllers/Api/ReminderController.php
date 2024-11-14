<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ReminderResource;
use App\Models\Event;
use App\Models\Reminder;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class ReminderController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param int $event_id
     * @return Response
     */
    public function index(int $event_id): Response
    {
        $reminders = Reminder::where('event_id', $event_id)
            //->where('is_sent', 0)
            ->orderBy('reminder_time', 'asc')
            ->get();

        return $this->sendResponse(ReminderResource::collection($reminders), 'Reminders retrieved successfully.');
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

        $validator = $this->validateReminder($request);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $reminder = Reminder::create($input);

        return $this->sendResponse(new ReminderResource($reminder), 'Reminder created successfully.' );
    }

    /**
     * Display the specified resource.
     *
     * @param Reminder $reminder
     * @return Response
     */
    public function show(Reminder $reminder)
    {
        return $this->sendResponse(new ReminderResource($reminder), 'Reminder retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Reminder $reminder
     * @return Response
     */
    public function update(Request $request, Reminder $reminder)
    {
        if (!$this->checkUserId($reminder)) {
            return $this->sendError('Unauthorized.');
        }

        $input = $request->all();

        $validator = $this->validateReminder($request);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $reminder->reminder_time = $input['reminder_time'];
        $reminder->is_sent = $input['is_sent'];
        $reminder->save();

        return $this->sendResponse(new ReminderResource($reminder), 'Reminder updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reminder $reminder
     * @return Response
     */
    public function destroy(Reminder $reminder)
    {
        if (!$this->checkUserId($reminder)) {
            return $this->sendError('Unauthorized.');
        }

        $reminder->delete();

        return $this->sendResponse([], 'Reminder deleted successfully.');
    }

    private function validateReminder(Request $request): \Illuminate\Validation\Validator
    {
        return Validator::make($request->all(), [
            'reminder_time' => 'required|date|after_or_equal:' . now(),
        ]);
    }

    private function checkUserId(Reminder $reminder): bool
    {
        $event = Event::find($reminder->event_id);
        return $event->user_id == auth()->id();
    }
}
