<?php

namespace App\Enums;

enum StatusEnum: string
{
    case NEW = "new";
    case IN_PROGRESS = "in_progress";
    case PENDING = "pending";
    case CORRECTION = "correction";
    case COMPLETED = "completed";
    case CANCELED = "canceled";
}
