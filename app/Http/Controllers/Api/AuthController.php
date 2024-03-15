<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiHelper;
use App\Helper\AuthHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:api')->except(['login', 'register']);
  }

  public function register(Request $request)
  {
    $validator = Validator::make($request->only(['name', 'email', 'password']), [
      'name' => 'required|max:255',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|max:255',
    ]);

    if ($validator->fails()) {
      return ApiHelper::sendResponse(400, $validator->messages());
    }

    try {
      $data = $validator->validated();
      $createdUser = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
      ]);

      return ApiHelper::sendResponse(201, data: $createdUser);
    } catch (Exception $e) {
      return ApiHelper::sendResponse(500, $e->getMessage());
    }
  }

  public function login(Request $request)
  {
    $validator = Validator::make($request->only(['email', 'password']), [
      'email' => 'required|email|exists:users,email',
      'password' => 'required|max:255',
    ]);

    if ($validator->fails()) {
      return ApiHelper::sendResponse(400, $validator->messages());
    }

    $credentials = $validator->validated();

    $user = User::where('email', $credentials['email'])->first();

    if (!$token = auth()->attempt($credentials)) {
      return ApiHelper::sendResponse(401, 'Unauthorized');
    }

    return AuthHelper::respondWithToken($token, $user);
  }

  public function me()
  {
    return ApiHelper::sendResponse(data: auth()->user());
  }

  public function logout()
  {
    auth()->logout();

    return ApiHelper::sendResponse(message: 'Logout success');
  }
}
