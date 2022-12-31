<?php

namespace App\Enums;

enum InvoiceStatus: string
{
    case NEW = 'new';
    case IN_PROGRESS = 'in_progress';
    case COMPLETE = 'complete';
}
