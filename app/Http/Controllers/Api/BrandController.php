<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth')->except(['index', 'show']);
  }

  /**
   * Get All Brand.
   *
   * @OA\Get(
   *     path="/api/brands",
   *     tags={"brand"},
   *     operationId="getBrands",
   *     security={{ "bearerAuth":{} }},
   *     @OA\Response(
   *         response=404,
   *         description="Not found",
   *         @OA\JsonContent
   *     ),
   *     @OA\Response(
   *         response=201,
   *         description="All Brands data",
   *         @OA\JsonContent
   *     ),
   * )
   */
  public function index(Request $request)
  {
    $brands = Brand::query();
    $name = $request->query('name');

    $brands->when($name, function ($query) use ($name) {
      return $query->whereRaw("name LIKE '%" . strtolower($name) . "%'");
    });

    return ApiHelper::sendResponse(data: $brands->get());
  }

  /**
   * Show cars from specific brand.
   *
   * @OA\Get(
   *     path="/api/brands/{id}",
   *     tags={"brand"},
   *     operationId="getCarsByBrand",
   *     security={{ "bearerAuth":{} }},
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         description="ID of Brand",
   *         required=true,
   *         @OA\Schema(type="integer"),
   *         example=1,
   *     ),
   *     @OA\Response(
   *         response=404,
   *         description="Not found",
   *         @OA\JsonContent
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Cars data",
   *         @OA\JsonContent
   *     ),
   * )
   */
  public function show(Brand $brand)
  {
    $cars = DB::table('brands as b')
      ->join('cars as c', 'c.brand_id', 'b.id')
      ->join('types as t', 't.id', 'c.type_id')
      ->where('b.id', $brand->id)
      ->select(
        'c.id',
        'c.name',
        'c.description',
        'c.price',
        'c.transmission',
        'c.condition',
        'c.year',
        'c.km',
        'c.stock',
        'c.image',
        't.name'
      )->get();

    return ApiHelper::sendResponse(data: $cars);
  }

  /**
   * Create Brand.
   *
   * @OA\Post(
   *     path="/api/brands",
   *     tags={"brand"},
   *     operationId="createBrand",
   *     security={{ "bearerAuth":{} }},
   *     @OA\Response(
   *         response=400,
   *         description="Invalid input",
   *         @OA\JsonContent
   *     ),
   *     @OA\Response(
   *         response=201,
   *         description="Create brand Successfully",
   *         @OA\JsonContent
   *     ),
   *  @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             type="object",
   *             @OA\Property(property="name", type="string", example="Toyota"),
   *             @OA\Property(property="logo_url", type="string", example="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRp4Wryh9n3wMIFmfRcNeBIi4K6N4T0hvH1_auy-o9gpqS9s7Z7Ei4S5arMmsPCQNgLBJ4&usqp=CAU"),
   *         ),
   *     ),
   * )
   */
  public function store(Request $request)
  {
    $validator = Validator::make($request->only(['name', 'logo_url']), [
      'name' => 'required|string|max:255',
      'logo_url' => 'required|url:https'
    ]);

    if ($validator->fails()) {
      return ApiHelper::sendResponse(400, $validator->messages());
    }

    try {
      $data = $validator->validated();
      $createdBrand = Brand::create($data);

      return ApiHelper::sendResponse(201, data: $createdBrand);
    } catch (Exception $e) {
      return ApiHelper::sendResponse(500, $e->getMessage());
    }
  }

  /**
   * Update Brand.
   *
   * @OA\Put(
   *     path="/api/brands/{id}",
   *     tags={"brand"},
   *     operationId="updateBrand",
   *     security={{ "bearerAuth":{} }},
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         description="ID of Brand",
   *         required=true,
   *         @OA\Schema(type="integer"),
   *         example=1,
   *     ),
   *     @OA\Response(
   *         response=400,
   *         description="Invalid input",
   *         @OA\JsonContent
   *     ),
   *     @OA\Response(
   *         response=201,
   *         description="Update brand Successfully",
   *         @OA\JsonContent
   *     ),
   *  @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             type="object",
   *             @OA\Property(property="name", type="string", example="Toyota"),
   *             @OA\Property(property="logo_url", type="string", example="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRp4Wryh9n3wMIFmfRcNeBIi4K6N4T0hvH1_auy-o9gpqS9s7Z7Ei4S5arMmsPCQNgLBJ4&usqp=CAU"),
   *         ),
   *     ),
   * )
   */

  public function update(Request $request, Brand $brand)
  {
    $validator = Validator::make($request->only(['name', 'logo_url']), [
      'name' => 'sometimes|required|string|max:255',
      'logo_url' => 'sometimes|required|url:https'
    ]);

    if ($validator->fails()) {
      return ApiHelper::sendResponse(400, $validator->messages());
    }

    try {
      $data = $validator->validated();
      $updatedBrand = $brand->update($data);

      return ApiHelper::sendResponse(201, data: $updatedBrand);
    } catch (Exception $e) {
      return ApiHelper::sendResponse(500, $e->getMessage());
    }
  }

  /**
   * Delete Brand.
   *
   * @OA\Delete(
   *     path="/api/brands/{id}",
   *     tags={"brand"},
   *     operationId="deleteBrand",
   *     security={{ "bearerAuth":{} }},
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         description="ID of brand",
   *         required=true,
   *         @OA\Schema(type="integer"),
   *         example=1,
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Delete brand Successfully",
   *         @OA\JsonContent
   *     ),
   * )
   */

  public function destroy(Brand $brand)
  {
    try {
      $deletedBrand = $brand->delete();
      return ApiHelper::sendResponse(200, data: $deletedBrand);
    } catch (Exception $e) {
      return ApiHelper::sendResponse(500, $e->getMessage());
    }
  }
}
