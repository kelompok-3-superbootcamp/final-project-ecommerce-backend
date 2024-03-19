<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Car extends Model
{
  use HasFactory;

  protected $guarded = ["id"];

  public function type(): BelongsTo
  {
    return $this->belongsTo(Type::class);
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function brand(): BelongsTo
  {
    return $this->belongsTo(Brand::class);
  }


  function reviews()
  {
    return $this->belongsTo(Review::class);
  }
}
