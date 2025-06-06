<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'user'        => new UserResource($this->whenLoaded('user')),
            'items'       => $this->items,
            'total_price' => $this->total_price,
            'status'      => $this->status,
            'payment_reference_id' => $this->payment_reference_id,
            'paid_at'              => $this->paid_at?->toDateTimeString(),
            'created_at'  => $this->created_at->toDateTimeString(),
        ];
    }
}
