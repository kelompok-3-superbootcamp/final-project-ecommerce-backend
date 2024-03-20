<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Car extends Model
{
  use HasFactory;
  protected $guarded = ['id'];

  public function review(): HasOne
  {
    return $this->hasOne(Review::class);
  }

  public function brand(): BelongsTo
  {
    return $this->belongsTo(Brand::class);
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function orders(): HasMany
  {
    return $this->hasMany(Order::class);
  }

  public function type(): BelongsTo
  {
    return $this->belongsTo(Type::class);
  }

  public function wishlists(): HasMany
  {
    return $this->hasMany(Wishlist::class);
  }
}
