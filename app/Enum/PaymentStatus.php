<?php

namespace App\Enum;

enum PaymentStatus: string
{
  case COMPLETE = 'complete';
  case PENDING = 'pending';
  case ERROR = 'error';
  case CLOSED = 'closed';
}
