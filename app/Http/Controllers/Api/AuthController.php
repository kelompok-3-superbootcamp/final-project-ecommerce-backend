<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiHelper;
use App\Helper\AuthHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

  public function changePassword(Request $request)
  {
    $validator = Validator::make($request->only(['old_password', 'new_password', 'password_confirmation']), [
      'old_password' => 'required',
      'new_password' => 'required',
      'password_confirmation' => 'required|same:new_password',
    ]);

    if ($validator->fails()) {
      return ApiHelper::sendResponse(400, $validator->messages());
    }

    try {
      $data = $validator->validated();

      if (!Hash::check($data['old_password'], Auth::user()->password)) {
        return ApiHelper::sendResponse(401, 'Unauthorized');
      }

      $updatedUserPassword = User::where('id', auth()->user()->id)->update([
        'password' => bcrypt($data['new_password'])
      ]);

      return ApiHelper::sendResponse(data: $updatedUserPassword);
    } catch (Exception $e) {
      return ApiHelper::sendResponse(500, $e->getMessage());
    }
  }
}
