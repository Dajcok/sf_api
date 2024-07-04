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
    public string $status;
    public JsonSerializable|null $data;

    public function __construct(string $message, ResponseStatusEnum $status, mixed $data = null)
    {
        $this->message = $message;
        $this->status = $status->value;
        $this->data = $data;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): string
    {
        return json_encode([
            'message' => $this->message,
            'status' => $this->status,
            'data' => $this->data?->jsonSerialize()
        ]);
    }
}
