<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'messages' => $this->messages,
            'created_at' => $this->created_at
                ? \Carbon\Carbon::parse($this->created_at)->format('d/m/Y H:i')
                : null,
            'read_at' => $this->read_at,
        ];
    }
}
