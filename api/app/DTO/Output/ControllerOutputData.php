<?php

namespace App\DTO\Output;

use app\Contracts\DTO\ArrayableContract;
use App\Enums\ResponseStatusEnum;
use App\Http\Requests\Request;
use Illuminate\Http\Resources\Json\JsonResource;
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
    public array $errors = [];
    public JsonResource|ArrayableContract|null $data;

    public function __construct(string $message, ResponseStatusEnum $status, mixed $data = null, array $errors = [])
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
                'data' => $this->data?->toArray() ?? new stdClass(),
            ]);
        }


        return json_encode([
            'message' => $this->message,
            'status' => $this->status,
            'errors' => $this->errors ?? new stdClass(),
        ]);
    }
}
