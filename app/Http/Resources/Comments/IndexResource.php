<?php

namespace App\Http\Resources\Comments;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
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
            'text' => $this->text,
            'file' => $this->file ? [
                'name' => $this->file?->name,
                'src' => asset('storage/' . $this->file?->path),
                'type' => $this->file?->type,
                'size' => round($this->file?->size * 0.00000095367432, 1),
            ] : null,
            'created_by' => $this->createdBy ? [
                'id' => $this->createdBy->id,
                'name' => $this->createdBy->name,
            ] : [],
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
