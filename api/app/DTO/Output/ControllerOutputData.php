<?php

namespace App\DTO\Output;

use App\Enums\ResponseStatusEnum;
use JsonSerializable;
use stdClass;

/**
 * This class is used to represent response structure from controllers to clients.
 *
 * @template T
 */
class ControllerOutputData implements JsonSerializable
{
    public string $message;
    public string $status;
    public ?array $errors = null;
    public ?array $data = null;

    public function __construct(string $message, ResponseStatusEnum $status, array $data = null, array $errors = null)
    {
        $this->message = $message;
        $this->status = $status->value;
        $this->data = $data;
        $this->errors = $errors;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): string
    {
        if ($this->status === ResponseStatusEnum::SUCCESS->value) {
            return json_encode([
                'message' => $this->message,
                'status' => $this->status,
                'data' => $this->data ?? new stdClass(),
            ]);
        }


        return json_encode([
            'message' => $this->message,
            'status' => $this->status,
            'errors' => $this->errors ?? new stdClass(),
        ]);
    }
}
