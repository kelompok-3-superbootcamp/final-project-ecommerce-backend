<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\User;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth')->except(['show', 'basedOnProfile']);
  }

  /**
   * Get all cars
   *
   * @OA\Get(
   *     path="/api/cars",
   *     tags={"cars"},
   *     description="Get all cars",
   *     operationId="getCars",
   *     @OA\Parameter(
   *         description="Name of car",
   *         in="query",
   *         name="name",
   *         @OA\Schema(type="string"),
   *         @OA\Examples(example="R34", value="R34", summary="car name"),
   *     ),
   *     @OA\Parameter(
   *         description="Color of car",
   *         in="query",
   *         name="color",
   *         @OA\Schema(type="string"),
   *         @OA\Examples(example="white", value="white", summary="car color"),
   *     ),
   *     @OA\Parameter(
   *         description="Transmission of car",
   *         in="query",
   *         name="transmission",
   *         @OA\Schema(type="string"),
   *         @OA\Examples(example="manual", value="manual", summary="car transmission (manual, automatic)"),
   *     ),
   *     @OA\Parameter(
   *         description="Location of car",
   *         in="query",
   *         name="location",
   *         @OA\Schema(type="string"),
   *         @OA\Examples(example="south", value="south", summary="car location"),
   *     ),
   *     @OA\Parameter(
   *         description="Condition of car",
   *         in="query",
   *         name="condition",
   *         @OA\Schema(type="string"),
   *         @OA\Examples(example="baru", value="baru", summary="car condition (baru, bekas)"),
   *     ),
   *     @OA\Parameter(
   *         description="min_price of car",
   *         in="query",
   *         name="min_price",
   *         @OA\Schema(type="integer"),
   *         @OA\Examples(example="100000", value="100000", summary="car min_price"),
   *     ),
   *     @OA\Parameter(
   *         description="max_price of car",
   *         in="query",
   *         name="max_price",
   *         @OA\Schema(type="integer"),
   *         @OA\Examples(example="100000", value="100000", summary="car max_price"),
   *     ),
   *     @OA\Parameter(
   *         description="min_km of car",
   *         in="query",
   *         name="min_km",
   *         @OA\Schema(type="integer"),
   *         @OA\Examples(example="769", value="769", summary="car min_km"),
   *     ),
   *     @OA\Parameter(
   *         description="max_km of car",
   *         in="query",
   *         name="max_km",
   *         @OA\Schema(type="integer"),
   *         @OA\Examples(example="769", value="769", summary="car max_km"),
   *     ),
   *     @OA\Parameter(
   *         description="brand_name of car",
   *         in="query",
   *         name="brand_name",
   *         @OA\Schema(type="string"),
   *         @OA\Examples(example="gtr", value="gtr", summary="car brand_name"),
   *     ),
   *     @OA\Parameter(
   *         description="type_name of car",
   *         in="query",
   *         name="type_name",
   *         @OA\Schema(type="string"),
   *         @OA\Examples(example="bensin", value="bensin", summary="car type_name"),
   *     ),
   *     @OA\Parameter(
   *         description="user_name of car",
   *         in="query",
   *         name="user_name",
   *         @OA\Schema(type="string"),
   *         @OA\Examples(example="john", value="john", summary="car user_name"),
   *     ),
   *     @OA\Parameter(
   *         description="order_by of car",
   *         in="query",
   *         name="order_by",
   *         @OA\Schema(type="string"),
   *         @OA\Examples(example="string", value="terlama", summary="car order_by (terlama|terbaru)"),
   *     ),
   *     @OA\Parameter(
   *         description="price_range of car",
   *         in="query",
   *         name="price_range",
   *         @OA\Schema(type="string"),
   *         @OA\Examples(example="string", value="termurah", summary="car price_range (termurah|termahal)"),
   *     ),
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
    // $cars = Car::query()->with(['brand', 'type', 'user']);
    $name = $request->query('name');
    $color = $request->query('color');
    $transmission = $request->query('transmission');
    $location = $request->query('location');
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
    $order = $request->query('order_by'); // Mendapatkan nama user dari permintaan
    $priceRange = $request->query('price_range'); // Mendapatkan nama user dari permintaan

    $cars = DB::table('cars as c')
      ->join('brands as b', 'b.id', 'c.brand_id')
      ->join('types as t', 't.id', 'c.type_id')
      ->join('users as u', 'u.id', 'c.user_id')
      ->leftJoin('wishlists as w', 'w.car_id', 'c.id');

    $cars->when($name, function (Builder $query) use ($name) {
      return $query->whereRaw("LOWER(c.name) LIKE '%" . strtolower($name) . "%'");
    });

    $cars->when($color, function (Builder $query) use ($color) {
      return $query->whereRaw("LOWER(c.color) LIKE '%" . strtolower($color) . "%'");
    });

    $cars->when($transmission, function (Builder $query) use ($transmission) {
      return $query->whereRaw("LOWER(c.transmission) LIKE '%" . strtolower($transmission) . "%'");
    });

    $cars->when($location, function (Builder $query) use ($location) {
      return $query->whereRaw("LOWER(c.location) LIKE '%" . strtolower($location) . "%'");
    });

    $cars->when($condition, function (Builder $query) use ($condition) {
      return $query->whereRaw("LOWER(c.condition) LIKE '%" . strtolower($condition) . "%'");
    });

    $cars->when($minKm, function (Builder $query) use ($minKm) {
      return $query->where('c.km', '>=', $minKm);
    });

    $cars->when($maxKm, function (Builder $query) use ($maxKm) {
      return $query->where('c.km', '<=', $maxKm);
    });


    $cars->when($minPrice, function (Builder $query) use ($minPrice) {
      return $query->where('c.price', '>=', $minPrice);
    });

    $cars->when($maxPrice, function (Builder $query) use ($maxPrice) {
      return $query->where('c.price', '<=', $maxPrice);
    });

    $cars->when($minYear, function (Builder $query) use ($minYear) {
      return $query->where('c.year', '>=', $minYear);
    });

    $cars->when($maxYear, function (Builder $query) use ($maxYear) {
      return $query->where('c.year', '<=', $maxYear);
    });


    $cars->when($brandName, function (Builder $query) use ($brandName) {
      return $query->where('b.name', 'like', '%' . $brandName . '%');
    });

    $cars->when($typeName, function (Builder $query) use ($typeName) {
      return $query->where('t.name', 'like', '%' . $typeName . '%');
    });

    $cars->when($userName, function (Builder $query) use ($userName) {
      return $query->where('u.name', 'like', '%' . $userName . '%');
    });

    $cars->when($priceRange, function (Builder $query) use ($priceRange) {
      $range = $priceRange === 'termurah' ? 'asc' : ($priceRange === 'termahal' ? 'desc' : 'asc');

      return $query->orderBy('c.price', $range);
    });

    $cars->when($order, function (Builder $query) use ($order) {
      $orderBy = $order === 'terlama' ? 'asc' : ($order === 'terbaru' ? 'desc' : 'asc');

      return $query->orderBy('c.created_at', $orderBy);
    });

    $current_auth_user_id = auth()->user()->id;

    return ApiHelper::sendResponse(data: $cars->select(
      'c.id',
      'c.name',
      'c.color',
      'c.description',
      'c.price',
      'c.transmission',
      'c.location',
      'c.condition',
      'c.year',
      'c.km',
      'c.stock',
      'c.image',
      't.name as type_name',
      'b.name as brand_name',
      'u.name as user_name',
      'c.created_at',
      'c.updated_at',
      DB::raw("IF(w.car_id IS NOT NULL AND w.user_id = $current_auth_user_id, 1, 0) as isWishList")
    )->paginate(10));
  }

  /**
   * Get all cars based on current logged seller
   *
   * @OA\Get(
   *     path="/api/cars/based-on-seller",
   *     tags={"cars"},
   *     description="Get all cars based on current logged seller",
   *     operationId="getCarsBasedOnSeller",
   *     security={{ "bearerAuth": {} }},
   *     @OA\Parameter(
   *         description="Name of car",
   *         in="query",
   *         name="name",
   *         @OA\Schema(type="string"),
   *         @OA\Examples(example="R34", value="R34", summary="car name"),
   *     ),
   *     @OA\Parameter(
   *         description="Color of car",
   *         in="query",
   *         name="color",
   *         @OA\Schema(type="string"),
   *         @OA\Examples(example="white", value="white", summary="car color"),
   *     ),
   *     @OA\Parameter(
   *         description="Transmission of car",
   *         in="query",
   *         name="transmission",
   *         @OA\Schema(type="string"),
   *         @OA\Examples(example="manual", value="manual", summary="car transmission (manual, automatic)"),
   *     ),
   *     @OA\Parameter(
   *         description="Location of car",
   *         in="query",
   *         name="location",
   *         @OA\Schema(type="string"),
   *         @OA\Examples(example="south", value="south", summary="car location"),
   *     ),
   *     @OA\Parameter(
   *         description="Condition of car",
   *         in="query",
   *         name="condition",
   *         @OA\Schema(type="string"),
   *         @OA\Examples(example="baru", value="baru", summary="car condition (baru, bekas)"),
   *     ),
   *     @OA\Parameter(
   *         description="min_price of car",
   *         in="query",
   *         name="min_price",
   *         @OA\Schema(type="integer"),
   *         @OA\Examples(example="100000", value="100000", summary="car min_price"),
   *     ),
   *     @OA\Parameter(
   *         description="max_price of car",
   *         in="query",
   *         name="max_price",
   *         @OA\Schema(type="integer"),
   *         @OA\Examples(example="100000", value="100000", summary="car max_price"),
   *     ),
   *     @OA\Parameter(
   *         description="min_km of car",
   *         in="query",
   *         name="min_km",
   *         @OA\Schema(type="integer"),
   *         @OA\Examples(example="769", value="769", summary="car min_km"),
   *     ),
   *     @OA\Parameter(
   *         description="max_km of car",
   *         in="query",
   *         name="max_km",
   *         @OA\Schema(type="integer"),
   *         @OA\Examples(example="769", value="769", summary="car max_km"),
   *     ),
   *     @OA\Parameter(
   *         description="brand_name of car",
   *         in="query",
   *         name="brand_name",
   *         @OA\Schema(type="string"),
   *         @OA\Examples(example="gtr", value="gtr", summary="car brand_name"),
   *     ),
   *     @OA\Parameter(
   *         description="type_name of car",
   *         in="query",
   *         name="type_name",
   *         @OA\Schema(type="string"),
   *         @OA\Examples(example="bensin", value="bensin", summary="car type_name"),
   *     ),
   *     @OA\Parameter(
   *         description="user_name of car",
   *         in="query",
   *         name="user_name",
   *         @OA\Schema(type="string"),
   *         @OA\Examples(example="john", value="john", summary="car user_name"),
   *     ),
   *     @OA\Parameter(
   *         description="order_by of car",
   *         in="query",
   *         name="order_by",
   *         @OA\Schema(type="string"),
   *         @OA\Examples(example="string", value="terlama", summary="car order_by (terlama|terbaru)"),
   *     ),
   *     @OA\Parameter(
   *         description="price_range of car",
   *         in="query",
   *         name="price_range",
   *         @OA\Schema(type="string"),
   *         @OA\Examples(example="string", value="termurah", summary="car price_range (termurah|termahal)"),
   *     ),
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
  public function basedOnSeller(Request $request)
  {
    $name = $request->query('name');
    $color = $request->query('color');
    $transmission = $request->query('transmission');
    $location = $request->query('location');
    $condition = $request->query('condition');
    $minPrice = $request->query('min_price'); // Mendapatkan harga minimum dari permintaan
    $maxPrice = $request->query('max_price'); // Mendapatkan harga maksimum dari permintaan
    $minKm = $request->query('min_km'); // Mendapatkan jarak minimum dari permintaan
    $maxKm = $request->query('max_km'); // Mendapatkan jarak maksimum dari permintaan
    $minYear = $request->query('min_year'); // Mendapatkan jarak minimum dari permintaan
    $maxYear = $request->query('max_year'); // Mendapatkan jarak maksimum dari permintaan
    $brandName = $request->query('brand_name'); // Mendapatkan nama merek dari permintaan
    $typeName = $request->query('type_name'); // Mendapatkan nama tipe dari permintaan
    $order = $request->query('order_by'); // Mendapatkan nama tipe dari permintaan
    $priceRange = $request->query('price_range'); // Mendapatkan nama user dari permintaan

    $cars = DB::table('cars as c')
      ->join('brands as b', 'b.id', 'c.brand_id')
      ->join('types as t', 't.id', 'c.type_id');

    $cars->when($name, function (Builder $query) use ($name) {
      return $query->whereRaw("LOWER(c.name) LIKE '%" . strtolower($name) . "%'");
    });

    $cars->when($color, function (Builder $query) use ($color) {
      return $query->whereRaw("LOWER(c.color) LIKE '%" . strtolower($color) . "%'");
    });

    $cars->when($transmission, function (Builder $query) use ($transmission) {
      return $query->whereRaw("LOWER(c.transmission) LIKE '%" . strtolower($transmission) . "%'");
    });

    $cars->when($location, function (Builder $query) use ($location) {
      return $query->whereRaw("LOWER(c.location) LIKE '%" . strtolower($location) . "%'");
    });

    $cars->when($condition, function (Builder $query) use ($condition) {
      return $query->whereRaw("LOWER(c.condition) LIKE '%" . strtolower($condition) . "%'");
    });

    $cars->when($minKm, function (Builder $query) use ($minKm) {
      return $query->where('c.km', '>=', $minKm);
    });

    $cars->when($maxKm, function (Builder $query) use ($maxKm) {
      return $query->where('c.km', '<=', $maxKm);
    });


    $cars->when($minPrice, function (Builder $query) use ($minPrice) {
      return $query->where('c.price', '>=', $minPrice);
    });

    $cars->when($maxPrice, function (Builder $query) use ($maxPrice) {
      return $query->where('c.price', '<=', $maxPrice);
    });

    $cars->when($minYear, function (Builder $query) use ($minYear) {
      return $query->where('c.year', '>=', $minYear);
    });

    $cars->when($maxYear, function (Builder $query) use ($maxYear) {
      return $query->where('c.year', '<=', $maxYear);
    });


    $cars->when($brandName, function (Builder $query) use ($brandName) {
      return $query->where('b.name', 'like', '%' . $brandName . '%');
    });

    $cars->when($typeName, function (Builder $query) use ($typeName) {
      return $query->where('t.name', 'like', '%' . $typeName . '%');
    });

    $cars->when($priceRange, function (Builder $query) use ($priceRange) {
      $range = $priceRange === 'termurah' ? 'asc' : ($priceRange === 'termahal' ? 'desc' : 'asc');

      return $query->orderBy('c.price', $range);
    });

    $cars->when($order, function (Builder $query) use ($order) {
      $orderBy = $order === 'terlama' ? 'asc' : ($order === 'terbaru' ? 'desc' : 'asc');

      return $query->orderBy('c.created_at', $orderBy);
    });

    return ApiHelper::sendResponse(data: $cars->where('c.user_id', auth()->user()->id)->select(
      'c.id',
      'c.name',
      'c.color',
      'c.description',
      'c.price',
      'c.transmission',
      'c.location',
      'c.condition',
      'c.year',
      'c.km',
      'c.stock',
      'c.image',
      't.name as type_name',
      'b.name as brand_name',
      'c.created_at',
      'c.updated_at',
    )->get());
  }

  /**
   * Get all cars based on profile id
   *
   * @OA\Get(
   *     path="/api/cars/based-on-profile/{id}",
   *     tags={"cars"},
   *     description="Get all cars based on profile id",
   *     operationId="getCarsBasedOnProfile",
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
  public function basedOnProfile(User $profile)
  {
    $cars = DB::table('cars as c')
      ->where('c.user_id', $profile->id)
      ->select(
        'c.id',
        'c.name',
        'c.description',
        'c.price',
        'c.transmission',
        'c.condition',
        'c.image',
        'c.created_at',
        'c.updated_at',
      )->get();

    $profile['cars'] = $cars;

    return ApiHelper::sendResponse(data: $profile);
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
  public function show($car_id)
  {
    $car = DB::table('cars as c')
      ->join('brands as b', 'b.id', 'c.brand_id')
      ->join('types as t', 't.id', 'c.type_id')
      ->where('c.id', $car_id)
      ->select(
        'c.id',
        'c.name',
        'c.color',
        'c.description',
        'c.price',
        'c.transmission',
        'c.location',
        'c.condition',
        'c.year',
        'c.km',
        'c.stock',
        'c.image',
        't.name as type_name',
        'b.name as brand_name',
        'c.created_at',
        'c.updated_at',
      )->first();

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
   *             @OA\Property(property="location", type="string"),
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
   *               @OA\Property(property="location", type="array",
   *                 @OA\Items(type="string", example="The location field is required")),
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
      'name', 'color', 'description', 'price', 'transmission', 'location', 'condition', 'year', 'km', 'stock', 'image', 'brand_id', 'type_id',
    ]), [
      'name' => 'required',
      'color' => 'required',
      'description' => 'required',
      'price' => 'required|integer',
      'transmission' => 'required|in:automatic,manual',
      'location' => 'required',
      'condition' => 'required|in:baru,bekas',
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
   *             @OA\Property(property="color", type="string"),
   *             @OA\Property(property="description", type="string"),
   *             @OA\Property(property="price", type="integer"),
   *             @OA\Property(property="transmission", type="string"),
   *             @OA\Property(property="location", type="string"),
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
   *               @OA\Property(property="color", type="array",
   *                 @OA\Items(type="string", example="The color field is required")),
   *               @OA\Property(property="description", type="array",
   *                 @OA\Items(type="string", example="The description field is required")),
   *               @OA\Property(property="price", type="array",
   *                 @OA\Items(type="string", example="The price field is required")),
   *               @OA\Property(property="transmission", type="array",
   *                 @OA\Items(type="string", example="The transmission field is required")),
   *               @OA\Property(property="location", type="array",
   *                 @OA\Items(type="string", example="The location field is required")),
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
      'name', 'color', 'description', 'price', 'transmission', 'location', 'condition', 'year', 'km', 'stock', 'image', 'brand_id', 'type_id',
    ]), [
      'name' => 'sometimes|required',
      'color' => 'sometimes|required',
      'description' => 'sometimes|required',
      'price' => 'sometimes|required|integer',
      'transmission' => 'sometimes|required',
      'location' => 'sometimes|required',
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

      $updatedCar = DB::table('cars')
        ->where('user_id', auth()->user()->id)
        ->where('id', $car->id)
        ->update($data);

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
    if (auth()->user()->role !== 'user' && auth()->user()->role !== 'admin') {
      return ApiHelper::sendResponse(403, 'Permission denied');
    }

    try {
      DB::table('cars')
        ->when(auth()->user()->role === 'user', function (Builder $query) use ($car) {
          return $query->where('user_id', auth()->user()->id)->where('id', $car->id);
        })
        ->when(auth()->user()->role === 'admin', function (Builder $query) use ($car) {
          return $query->where('id', $car->id);
        })
        ->delete();

      return ApiHelper::sendResponse(200);
    } catch (Exception $e) {
      return ApiHelper::sendResponse(500, $e->getMessage());
    }
  }
}
