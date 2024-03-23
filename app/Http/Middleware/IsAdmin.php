<?php

namespace App\Http\Middleware;

use App\Helper\ApiHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    if ($request->user()->role !== 'admin') {
      return ApiHelper::sendResponse(403, 'Anda bukan admin');
    }
    return $next($request);
  }
}
