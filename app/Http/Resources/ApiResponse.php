<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResponse extends JsonResource
{
    private $message;
    private $status;

    public function __construct($resource, string $message = null, int $status = 200)
    {
        parent::__construct($resource);
        $this->message = $message;
        $this->status = $status;
    }

    public function toArray($request)
    {
        return [
            'status' => $this->status === 200 ? 'success' : 'error',
            'message' => $this->message,
            'data' => $this->resource,
        ];
    }
}
