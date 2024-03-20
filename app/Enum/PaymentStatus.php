<?php

namespace App\Enum;

enum PaymentStatus: string
{
  case COMPLETE = 'success';
  case PENDING = 'pending';
  case ERROR = 'error';
  case CLOSED = 'closed';
}
