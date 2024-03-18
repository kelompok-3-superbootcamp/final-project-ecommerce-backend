<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\Car;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth')->except(['index', 'show']);
  }

  /**
   * Get all cars
   *
   * @OA\Get(
   *     path="/api/cars",
   *     tags={"cars"},
   *     description="Get all cars",
   *     operationId="index_cars",
   *     @OA\Response(
   *         response="200",
   *         description="Successful get data cars",
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
    return ApiHelper::sendResponse(data: Car::all());
  }

  /**
   * Get a car
   *
   * @OA\Get(
   *     path="/api/cars/{id}",
   *     tags={"cars"},
   *     description="Get a car",
   *     operationId="show_cars",
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
   *         description="Successful get a data of car",
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
  public function show(Car $car)
  {
    return ApiHelper::sendResponse(data: $car);
  }

  /**
   * Add a car
   *
   * @OA\Post(
   *     path="/api/cars",
   *     tags={"cars"},
   *     description="Add type of a car",
   *     operationId="store_cars",
   *     security={{ "bearerAuth": {} }},
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             type="object",
   *             @OA\Property(property="name", type="string"),
   *             @OA\Property(property="description", type="string"),
   *             @OA\Property(property="price", type="integer"),
   *             @OA\Property(property="transmission", type="string"),
   *             @OA\Property(property="condition", type="string"),
   *             @OA\Property(property="year", type="integer"),
   *             @OA\Property(property="km", type="integer"),
   *             @OA\Property(property="stock", type="integer"),
   *             @OA\Property(property="image", type="string"),
   *             @OA\Property(property="brand_id", type="integer"),
   *             @OA\Property(property="type_id", type="integer"),
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
   *         description="Successful add data car",
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
      'name', 'description', 'price', 'transmission', 'condition', 'year', 'km', 'stock', 'image', 'brand_id', 'type_id',
    ]), [
      'name' => 'required',
      'description' => 'required',
      'price' => 'required|integer',
      'transmission' => 'required',
      'condition' => 'required',
      'year' => 'required|integer',
      'km' => 'required|integer',
      'stock' => 'required|integer',
      'image' => 'required',
      'brand_id' => 'required|integer',
      'type_id' => 'required|integer',
    ]);

    if ($validator->fails()) {
      return ApiHelper::sendResponse(400, $validator->messages());
    }

    try {
      $data = $validator->validated();
      $data['user_id'] = auth()->user()->id;

      $createdCar = Car::create($data);

      return ApiHelper::sendResponse(201, data: $createdCar);
    } catch (Exception $e) {
      return ApiHelper::sendResponse(500, $e->getMessage());
    }
  }


  /**
   * Edit a car
   *
   * @OA\Put(
   *     path="/api/cars/{id}",
   *     tags={"cars"},
   *     description="Edit a car",
   *     operationId="update_cars",
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
   *             @OA\Property(property="name", type="string"),
   *             @OA\Property(property="description", type="string"),
   *             @OA\Property(property="price", type="integer"),
   *             @OA\Property(property="transmission", type="string"),
   *             @OA\Property(property="condition", type="string"),
   *             @OA\Property(property="year", type="integer"),
   *             @OA\Property(property="km", type="integer"),
   *             @OA\Property(property="stock", type="integer"),
   *             @OA\Property(property="image", type="string"),
   *             @OA\Property(property="brand_id", type="integer"),
   *             @OA\Property(property="type_id", type="integer"),
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
   *         description="Successful update car data",
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
  public function update(Car $car, Request $request)
  {
    $validator = Validator::make($request->only([
      'name', 'description', 'price', 'transmission', 'condition', 'year', 'km', 'stock', 'image', 'brand_id', 'type_id',
    ]), [
      'name' => 'sometimes|required',
      'description' => 'sometimes|required',
      'price' => 'sometimes|required|integer',
      'transmission' => 'sometimes|required',
      'condition' => 'sometimes|required',
      'year' => 'sometimes|required|integer',
      'km' => 'sometimes|required|integer',
      'stock' => 'sometimes|required|integer',
      'image' => 'sometimes|required',
      'brand_id' => 'sometimes|required|integer',
      'type_id' => 'sometimes|required|integer',
    ]);

    if ($validator->fails()) {
      return ApiHelper::sendResponse(400, $validator->messages());
    }

    try {
      $data = $validator->validated();
      $data['user_id'] = auth()->user()->id;

      $updatedCar = $car->update($data);

      return ApiHelper::sendResponse(201, data: $updatedCar);
    } catch (Exception $e) {
      return ApiHelper::sendResponse(500, $e->getMessage());
    }
  }


  /**
   * Delete a car
   *
   * @OA\Delete(
   *     path="/api/cars/{id}",
   *     tags={"cars"},
   *     description="Delete a car",
   *     operationId="destroy_cars",
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
  public function destroy(Car $car)
  {
    try {
      $car->delete();

      return ApiHelper::sendResponse(200);
    } catch (Exception $e) {
      return ApiHelper::sendResponse(500, $e->getMessage());
    }
  }
}
