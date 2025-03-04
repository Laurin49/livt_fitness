<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExerciseWorkoutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'beschreibung' => $this->beschreibung,
            'workout' => new WorkoutResource($this->whenLoaded('workout')),
            'exercise' => new ExerciseResource($this->whenLoaded('exercise')),
        ];
    }
}
