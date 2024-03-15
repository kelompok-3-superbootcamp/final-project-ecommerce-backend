<?php

namespace App\Helper;

class AuthHelper
{
  public static function respondWithToken($token, $user)
  {
    return ApiHelper::sendResponse(data: [
      'user' => $user,
      'access_token' => $token,
      'token_type' => 'bearer',
      'expires_in' => auth()->factory()->getTTL() * 60
    ]);
  }
}
