<?php

namespace App\Http\Resources\Api\Task;

use App\Traits\FormatsDates;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    use FormatsDates;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->formatDate($this->created_at),
            'updated_at' => $this->formatDate($this->updated_at),
            'title' => $this->title,
            'author_id' => $this->author_id,
            'reader_user_id' => $this->reader_user_id,
            'text' => $this->text,
            'status' => $this->status,
            'deadline_date' => $this->formatDate($this->deadline_date),
        ];
    }
}
