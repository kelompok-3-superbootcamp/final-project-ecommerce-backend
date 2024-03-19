<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth')->except(['index', 'show']);
  }
  /**
   * Get all wishlists
   *
   * @OA\Get(
   *     path="/api/wishlists",
   *     tags={"wishlists"},
   *     description="Get all wishlists",
   *     security={{ "bearerAuth": {} }},
   *     operationId="index_wishlists",
   *     @OA\Response(
   *         response="200",
   *         description="Successful get data wishlists",
   *         @OA\JsonContent(
   *             @OA\Property(
   *                 property="status",
   *                 type="integer",
   *                 example="200",
   *             ),
   *             @OA\Property(
   *                 property="message",
   *                 type="string",
   *                 example="ok",
   *             ),
   *             @OA\Property(
   *                 property="data",
   *                 type="object",
   *             ),
   *         )
   *     )
   * )
   */
  public function index()
  {
    $wishlists = Wishlist::where('user_id', auth()->user()->id)->get();
    return ApiHelper::sendResponse(data: $wishlists);
  }

  /**
   * Add a Wishlist
   *
   * @OA\Post(
   *     path="/api/wishlists",
   *     tags={"wishlists"},
   *     description="Add a Wishlist",
   *     operationId="store_wishlists",
   *     security={{ "bearerAuth": {} }},
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             type="object",
   *             @OA\Property(property="car_id", type="integer", example="2"),
   *         )
   *     ),
   *     @OA\Response(
   *        response=400,
   *        description="Validation Error",
   *        @OA\JsonContent(
   *           @OA\Property(property="status", type="integer", example="400"),
   *           @OA\Property(property="message", type="object",
   *               @OA\Property(property="name", type="array",
   *                 @OA\Items(type="string", example="The name field is required")),
   *               @OA\Property(property="description", type="array",
   *                 @OA\Items(type="string", example="The description field is required")),
   *           ),
   *        ),
   *     ),
   *     @OA\Response(
   *         response="200",
   *         description="Successful add data wishlist",
   *         @OA\JsonContent(
   *             @OA\Property(
   *                 property="status",
   *                 type="integer",
   *                 example="201",
   *             ),
   *             @OA\Property(
   *                 property="message",
   *                 type="string",
   *                 example="ok",
   *             ),
   *             @OA\Property(
   *                 property="data",
   *                 type="object",
   *             ),
   *         )
   *     )
   * )
   */
  public function store(Request $request)
  {
    $validator = Validator::make($request->only(['car_id']), [
      'car_id' => 'required|integer'
    ]);

    if ($validator->fails()) {
      return ApiHelper::sendResponse(400, $validator->messages());
    }

    try {
      $data = $validator->validated();
      $data['user_id'] = auth()->user()->id;

      $createdWishlist = Wishlist::create($data);

      return ApiHelper::sendResponse(201, data: $createdWishlist);
    } catch (Exception $e) {
      return ApiHelper::sendResponse(500, $e->getMessage());
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(Wishlist $wishlist)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Wishlist $wishlist)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Wishlist $wishlist)
  {
    //
  }

  /**
   * Delete a wishlist
   *
   * @OA\Delete(
   *     path="/api/wishlists/{id}",
   *     tags={"wishlists"},
   *     description="Delete a wishlist",
   *     operationId="destroy_wishlists",
   *     security={{ "bearerAuth": {} }},
   *     @OA\Parameter(
   *         description="Parameter id",
   *         in="path",
   *         name="id",
   *         required=true,
   *         @OA\Schema(type="integer"),
   *         @OA\Examples(example="int", value="1", summary="Parameter id."),
   *     ),
   *     @OA\Response(
   *         response="200",
   *         description="Successful delete data type",
   *         @OA\JsonContent(
   *             @OA\Property(
   *                 property="status",
   *                 type="integer",
   *                 example="200",
   *             ),
   *             @OA\Property(
   *                 property="message",
   *                 type="string",
   *                 example="ok",
   *             ),
   *             @OA\Property(
   *                 property="data",
   *                 type="object",
   *             ),
   *         )
   *     )
   * )
   */
  public function destroy(Wishlist $wishlist)
  {
    try {
      $wishlist->delete();

      return ApiHelper::sendResponse(200);
    } catch (Exception $e) {
      return ApiHelper::sendResponse(500, $e->getMessage());
    }
  }
}
