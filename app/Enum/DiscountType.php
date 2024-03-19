<?php

namespace App\Enum;

enum DiscountType: string
{
  case PERCENTAGE = 'percentage';
  case NOMINAL = 'nominal';
}
