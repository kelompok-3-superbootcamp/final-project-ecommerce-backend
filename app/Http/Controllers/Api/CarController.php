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
   *     operationId="getCars",
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
  public function index(Request $request)
  {
    $cars = Car::query()->with(['brand', 'type', 'user']);
    $name = $request->query('name');
    $transmission = $request->query('transmission');
    $condition = $request->query('condition');
    $minPrice = $request->query('min_price'); // Mendapatkan harga minimum dari permintaan
    $maxPrice = $request->query('max_price'); // Mendapatkan harga maksimum dari permintaan
    $minKm = $request->query('min_km'); // Mendapatkan jarak minimum dari permintaan
    $maxKm = $request->query('max_km'); // Mendapatkan jarak maksimum dari permintaan
    $minYear = $request->query('min_year'); // Mendapatkan jarak minimum dari permintaan
    $maxYear = $request->query('max_year'); // Mendapatkan jarak maksimum dari permintaan
    $brandName = $request->query('brand_name'); // Mendapatkan nama merek dari permintaan
    $typeName = $request->query('type_name'); // Mendapatkan nama tipe dari permintaan
    $userName = $request->query('user_name'); // Mendapatkan nama user dari permintaan

    $cars->when($name, function ($query) use ($name) {
      return $query->whereRaw("name LIKE '%" . strtolower($name) . "%'");
    });

    $cars->when($transmission, function ($query) use ($transmission) {
      return $query->whereRaw("transmission LIKE '%" . strtolower($transmission) . "%'");
    });

    $cars->when($condition, function ($query) use ($condition) {
      return $query->whereRaw("condition LIKE '%" . strtolower($condition) . "%'");
    });

    $cars->when($minKm, function ($query) use ($minKm) {
      return $query->where('km', '>=', $minKm);
    });

    $cars->when($maxKm, function ($query) use ($maxKm) {
      return $query->where('km', '<=', $maxKm);
    });


    $cars->when($minPrice, function ($query) use ($minPrice) {
      return $query->where('price', '>=', $minPrice);
    });

    $cars->when($maxPrice, function ($query) use ($maxPrice) {
      return $query->where('price', '<=', $maxPrice);
    });

    $cars->when($minYear, function ($query) use ($minYear) {
      return $query->where('year', '>=', $minYear);
    });

    $cars->when($maxYear, function ($query) use ($maxYear) {
      return $query->where('year', '<=', $maxYear);
    });


    $cars->when($brandName, function ($query) use ($brandName) {
      return $query->whereHas('brand', function ($query) use ($brandName) {
        $query->where('name', 'like', '%' . $brandName . '%');
      });
    });

    $cars->when($typeName, function ($query) use ($typeName) {
      return $query->whereHas('type', function ($query) use ($typeName) {
        $query->where('name', 'like', '%' . $typeName . '%');
      });
    });

    $cars->when($userName, function ($query) use ($userName) {
      return $query->whereHas('user', function ($query) use ($userName) {
        $query->where('name', 'like', '%' . $userName . '%');
      });
    });


    return ApiHelper::sendResponse(data: $cars->get());
  }

  /**
   * Get a car
   *
   * @OA\Get(
   *     path="/api/cars/{id}",
   *     tags={"cars"},
   *     description="Get a car",
   *     operationId="getCarById",
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
   *     operationId="createCar",
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
   *               @OA\Property(property="price", type="array",
   *                 @OA\Items(type="string", example="The price field is required")),
   *               @OA\Property(property="transmission", type="array",
   *                 @OA\Items(type="string", example="The transmission field is required")),
   *               @OA\Property(property="condition", type="array",
   *                 @OA\Items(type="string", example="The condition field is required")),
   *               @OA\Property(property="year", type="array",
   *                 @OA\Items(type="string", example="The year field is required")),
   *               @OA\Property(property="km", type="array",
   *                 @OA\Items(type="string", example="The km field is required")),
   *               @OA\Property(property="stock", type="array",
   *                 @OA\Items(type="string", example="The stock field is required")),
   *               @OA\Property(property="image", type="array",
   *                 @OA\Items(type="string", example="The image field is required")),
   *               @OA\Property(property="brand_id", type="array",
   *                 @OA\Items(type="string", example="The brand_id field is required")),
   *               @OA\Property(property="type_id", type="array",
   *                 @OA\Items(type="string", example="The type_id field is required")),
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
   *               @OA\Property(property="price", type="array",
   *                 @OA\Items(type="string", example="The price field is required")),
   *               @OA\Property(property="transmission", type="array",
   *                 @OA\Items(type="string", example="The transmission field is required")),
   *               @OA\Property(property="condition", type="array",
   *                 @OA\Items(type="string", example="The condition field is required")),
   *               @OA\Property(property="year", type="array",
   *                 @OA\Items(type="string", example="The year field is required")),
   *               @OA\Property(property="km", type="array",
   *                 @OA\Items(type="string", example="The km field is required")),
   *               @OA\Property(property="stock", type="array",
   *                 @OA\Items(type="string", example="The stock field is required")),
   *               @OA\Property(property="image", type="array",
   *                 @OA\Items(type="string", example="The image field is required")),
   *               @OA\Property(property="brand_id", type="array",
   *                 @OA\Items(type="string", example="The brand_id field is required")),
   *               @OA\Property(property="type_id", type="array",
   *                 @OA\Items(type="string", example="The type_id field is required")),
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
