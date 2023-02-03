<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    private $message;
    private $token;
    private $exp;

    public function __construct(array $authorization, string $message = null)
    {
        parent::__construct($authorization['user']);
        $this->message = $message;
        $this->token = $authorization['token'] ?? null;
        $this->exp = $authorization['exp'] ?? 60; // in minutes
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'message' => $this->message,
            'data' => [
                'user' => [
                    '_id' => $this->id,
                    'name' => $this->name,
                    'email' => $this->email
                ],
                $this->mergeWhen($this->token, [
                    'authorization' => [
                    'token' => $this->token,
                    'type' => 'Bearer',
                    'expired' => $this->exp * 60 // in seconds
                    ]
                ])
            ]
        ];
    }
}
