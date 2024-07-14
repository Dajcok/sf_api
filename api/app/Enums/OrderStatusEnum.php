<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case ACTIVE = 'ACTIVE';
    case CANCELED = 'CANCELED';
    case DONE = 'DONE';
}
