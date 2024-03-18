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

  /**
   * Registering a user.
   *
   * @OA\Post(
   *     path="/api/auth/register",
   *     tags={"auth"},
   *     operationId="register",
   *     @OA\Response(
   *         response=401,
   *         description="Invalid input",
   *         @OA\JsonContent
   *     ),
   *     @OA\Response(
   *         response=201,
   *         description="Register account Successfully",
   *         @OA\JsonContent
   *     ),
   *  @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             type="object",
   *             @OA\Property(property="name", type="string", example="Adi Cahya S"),
   *             @OA\Property(property="email", type="string", example="adics@gmail.com"),
   *             @OA\Property(property="phone_number", type="string", example="62812345678910"),
   *             @OA\Property(property="password", type="string", example="pw"),
   *         ),
   *     ),
   * )
   */
  public function register(Request $request)
  {
    $validator = Validator::make($request->only(['name', 'email', 'password', 'phone_number']), [
      'name' => 'required|max:255',
      'email' => 'required|email|unique:users,email',
      'phone_number' => 'required|numeric|digits_between:11,14',
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
        'phone_number' => $data['phone_number'],
        'role' => 'user',
        'password' => bcrypt($data['password']),
      ]);

      return ApiHelper::sendResponse(201, data: $createdUser);
    } catch (Exception $e) {
      return ApiHelper::sendResponse(500, $e->getMessage());
    }
  }

  /**
   * Login.
   *
   * @OA\Post(
   *     path="/api/auth/login",
   *     tags={"auth"},
   *     operationId="login",
   *     @OA\Response(
   *         response=401,
   *         description="Invalid input",
   *         @OA\JsonContent
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Login Successfully",
   *         @OA\JsonContent
   *     ),
   *  @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             type="object",
   *             @OA\Property(property="email", type="string", example="adics@gmail.com"),
   *             @OA\Property(property="password", type="string", example="pw"),
   *         ),
   *     ),
   * )
   */
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

  /**
   * Get Current user.
   *
   * @OA\Post(
   *     path="/api/auth/me",
   *     tags={"auth"},
   *     operationId="me",
   *     security={{ "bearerAuth":{} }},
   *     @OA\Response(
   *         response=401,
   *         description="Unauthorized",
   *         @OA\JsonContent
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Show current user data",
   *         @OA\JsonContent
   *     ),
   * )
   */
  public function me()
  {
    return ApiHelper::sendResponse(data: auth()->user());
  }

  /**
   * Logged Out Current user.
   *
   * @OA\Post(
   *     path="/api/auth/logout",
   *     tags={"auth"},
   *     operationId="logout",
   *     security={{ "bearerAuth":{} }},
   *     @OA\Response(
   *         response=401,
   *         description="Unauthorized",
   *         @OA\JsonContent
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Logout",
   *         @OA\JsonContent
   *     ),
   * )
   */
  public function logout()
  {
    auth()->logout();

    return ApiHelper::sendResponse(message: 'Logout success');
  }

  /**
   * Change Password.
   *
   * @OA\Post(
   *     path="/api/auth/change-password",
   *     tags={"auth"},
   *     operationId="changePassword",
   *     security={{ "bearerAuth":{} }},
   *     @OA\Response(
   *         response=401,
   *         description="Invalid input",
   *         @OA\JsonContent
   *     ),
   *     @OA\Response(
   *         response=201,
   *         description="Change Password account Successfully",
   *         @OA\JsonContent
   *     ),
   *  @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             type="object",
   *             @OA\Property(property="old_password", type="string", example="old_pw"),
   *             @OA\Property(property="new_password", type="string", example="new_pw"),
   *             @OA\Property(property="password_confirmation", type="string", example="new_pw"),
   *         ),
   *     ),
   * )
   */
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
