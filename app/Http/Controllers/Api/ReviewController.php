<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Car;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth')->except(['index', 'show', 'avarageRatingCar', 'carReviews']);
  }

  /**
   * Get all reviews
   *
   * @OA\Get(
   *     path="/api/reviews",
   *     tags={"reviews"},
   *     description="Get all reviews",
   *     operationId="index_reviews",
   *     @OA\Response(
   *         response="200",
   *         description="Successful get data reviews",
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
    return ApiHelper::sendResponse(data: Review::all());
  }

  /**
   * Get all reviews
   *
   * @OA\Get(
   *     path="/api/reviews/for-seller",
   *     tags={"reviews"},
   *     description="Get all reviews",
   *     security={{ "bearerAuth": {} }},
   *     operationId="index_reviews_based_on_seller",
   *     @OA\Response(
   *         response="200",
   *         description="Successful get data reviews",
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
  public function forSeller()
  {
    $user = auth()->user();
    $cars = Car::where('user_id', $user->id)->pluck('id');
    $reviews = Review::whereIn('car_id', $cars)->get();
    return ApiHelper::sendResponse(data: $reviews);
  }

  /**
   * Get avarage star count
   *
   * @OA\Get(
   *     path="/api/reviews/avarage/{car_id}",
   *     tags={"reviews"},
   *     description="Get avarage star count",
   *     operationId="avarageRatingCar_reviews",
   *     @OA\Parameter(
   *         description="Parameter id",
   *         in="path",
   *         name="car_id",
   *         required=true,
   *         @OA\Schema(type="integer"),
   *         @OA\Examples(example="int", value="1", summary="Parameter id."),
   *     ),
   *     @OA\Response(
   *         response="200",
   *         description="Successful get data avg reviews",
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
  public function avarageRatingCar($car_id)
  {
    $avarage = DB::table('reviews as r')
      ->join('cars as c', 'c.id', 'r.car_id')
      ->where('c.id', $car_id)
      ->average('r.star_count');

    return ApiHelper::sendResponse(data: (int) $avarage);
  }

  /**
   * Get car review
   *
   * @OA\Get(
   *     path="/api/reviews/car/{car_id}",
   *     tags={"reviews"},
   *     description="Get car review",
   *     operationId="getCar_reviews",
   *     @OA\Parameter(
   *         description="Parameter id",
   *         in="path",
   *         name="car_id",
   *         required=true,
   *         @OA\Schema(type="integer"),
   *         @OA\Examples(example="int", value="1", summary="Parameter id."),
   *     ),
   *     @OA\Response(
   *         response="200",
   *         description="Successful get data car reviews",
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
  public function carReviews($car_id)
  {
    $reviews = DB::table('reviews as r')
      ->join('cars as c', 'c.id', 'r.car_id')
      ->join('users as u', 'u.id', 'r.user_id')
      ->where('c.id', $car_id)
      ->select('r.id', 'r.star_count', 'r.comment', 'u.name as user_name')->get();

    return ApiHelper::sendResponse(data: $reviews);
  }

  /**
   * Get a review
   *
   * @OA\Get(
   *     path="/api/reviews/{id}",
   *     tags={"reviews"},
   *     description="Get a review",
   *     operationId="show_reviews",
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
   *         description="Successful get a data of review",
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
  public function show(Review $review)
  {
    return ApiHelper::sendResponse(data: $review);
  }

  /**
   * Add a review
   *
   * @OA\Post(
   *     path="/api/reviews",
   *     tags={"reviews"},
   *     description="Add type of a review",
   *     operationId="store_reviews",
   *     security={{ "bearerAuth": {} }},
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             type="object",
   *             @OA\Property(property="car_id", type="integer"),
   *             @OA\Property(property="star_count", type="integer"),
   *             @OA\Property(property="comment", type="string"),
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
   *         description="Successful add data review",
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
    $validator = Validator::make($request->only([
      'car_id', 'star_count', 'comment',
    ]), [
      'car_id' => 'required',
      'star_count' => 'required',
      'comment' => 'required'
    ]);

    if ($validator->fails()) {
      return ApiHelper::sendResponse(400, $validator->messages());
    }

    try {
      $data = $validator->validated();
      $data['user_id'] = auth()->user()->id;

      $createdReview = Review::create($data);

      return ApiHelper::sendResponse(201, data: $createdReview);
    } catch (Exception $e) {
      return ApiHelper::sendResponse(500, $e->getMessage());
    }
  }
  /**
   * Edit a review
   *
   * @OA\Put(
   *     path="/api/reviews/{id}",
   *     tags={"reviews"},
   *     description="Edit a review",
   *     operationId="reviews",
   *     security={{ "bearerAuth": {} }},
   *     @OA\Parameter(
   *         description="Parameter id",
   *         in="path",
   *         name="id",
   *         required=true,
   *         @OA\Schema(type="integer"),
   *         @OA\Examples(example="int", value="1", summary="Parameter id."),
   *     ),
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             type="object",
   *             @OA\Property(property="car_id", type="integer"),
   *             @OA\Property(property="star_count", type="integer"),
   *             @OA\Property(property="comment", type="string"),
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
   *         description="Successful update review data",
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
  public function update(Request $request, Review $review)
  {
    $validator = Validator::make($request->only([
      'car_id', 'star_count', 'comment',
    ]), [
      'car_id' => 'sometimes|required|integer',
      'star_count' => 'sometimes|required|integer',
      'comment' => 'sometimes|required',
    ]);

    if ($validator->fails()) {
      return ApiHelper::sendResponse(400, $validator->messages());
    }

    try {
      $data = $validator->validated();
      $data['user_id'] = auth()->user()->id;

      $updatedReview = $review->update($data);

      return ApiHelper::sendResponse(201, data: $updatedReview);
    } catch (Exception $e) {
      return ApiHelper::sendResponse(500, $e->getMessage());
    }
  }

  /**
   * Delete a review
   *
   * @OA\Delete(
   *     path="/api/reviews/{id}",
   *     tags={"reviews"},
   *     description="Delete a review",
   *     operationId="destroy_reviews",
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
  public function destroy(Review $review)
  {
    try {
      $review->delete();

      return ApiHelper::sendResponse(200);
    } catch (Exception $e) {
      return ApiHelper::sendResponse(500, $e->getMessage());
    }
  }
}
