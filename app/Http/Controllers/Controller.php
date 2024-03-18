<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="Sanber Car API",
 *     description="sanber-car final project API Documentation",
 *     version="0.1",
 * ),
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 * ),
 * @OA\Header(
 *     header="Accept",
 *     description="Accept header",
 *     @OA\Schema(type="string", example="application/json"),
 * )
 */
class Controller extends BaseController
{
  use AuthorizesRequests, ValidatesRequests;
}
