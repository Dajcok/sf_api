<?php

namespace App\DTO\Output;

use App\Enums\ResponseStatusEnum;
use JsonSerializable;

/**
 * This class is used to represent response structure from controllers to client.
 *
 * @template T
 */
class ControllerOutputData implements JsonSerializable
{
    public string $message;
    public ResponseStatusEnum $status;
    /**
     * @var T|null
     */
    public mixed $data;

    public function __construct(string $message, ResponseStatusEnum $status, mixed $data = null)
    {
        $this->message = $message;
        $this->status = $status;
        $this->data = $data;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'message' => $this->message,
            'status' => $this->status,
            'data' => $this->data,
        ];
    }
}
