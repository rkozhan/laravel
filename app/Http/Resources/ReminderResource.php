<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReminderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'event_id' => $this->event_id,
            'reminder_time' => $this->reminder_time,
            'is_sent' => $this->is_sent,
            //'created_at' => $this->created_at->format('d/m/Y'),
            //'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
