<?php

namespace App\Rules;

use App\Enum\DiscountType;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DiscountValueValidation implements ValidationRule
{
  /**
   * Run the validation rule.
   *
   * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
   */
  public function validate(string $attribute, mixed $value, Closure $fail): void
  {
    $request = request()->all();

    if ($request['discount_type'] === DiscountType::PERCENTAGE) {
      $isPercentage = is_numeric($value) && $value >= 0 && $value <= 100;

      if (!$isPercentage) {
        $fail('The :attribute is not valid percentage');
      }
    }

    if ($request['discount_type'] === DiscountType::NOMINAL) {
      $isNominal = !empty($value) && is_numeric($value) && $value >= 0;

      if (!$isNominal) {
        $fail('The :attribute is not valid nominal');
      }
    }
  }
}
