<?php

namespace App\Http\Resources\Api\Task;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author_id' => $this->author_id,
            'reader_user_id' => $this->reader_user_id,
            'text' => $this->text,
            'status' => $this->status,
            'deadline_date' => Carbon::parse($this->deadline_date)->format('Y-m-d H:i:s')
        ];
    }
}
