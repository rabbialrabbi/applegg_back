<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $token = $this->createToken($this->name.'-AuthToken')->plainTextToken;
        return [
            'user' =>[
                'name' => $this->name,
                'email' => $this->email,
                'created_at' => $this->created_at
            ],
            'token' => $token,

        ];
    }
}
