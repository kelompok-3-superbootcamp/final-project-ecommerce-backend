<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth')->except(['index']);
  }

  public function index()
  {
    return ApiHelper::sendResponse(data: Category::all());
  }

  public function show(Category $category)
  {
    return ApiHelper::sendResponse(data: $category);
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->only(['name', 'description']), [
      'name' => 'required',
      'description' => 'required',
    ]);

    if ($validator->fails()) {
      return ApiHelper::sendResponse(400, $validator->messages());
    }

    try {
      $data = $validator->validated();

      $createdCategory = Category::create($data);

      return ApiHelper::sendResponse(201, data: $createdCategory);
    } catch (Exception $e) {
      return ApiHelper::sendResponse(500, $e->getMessage());
    }
  }

  public function update(Category $category, Request $request)
  {
    $validator = Validator::make($request->only(['name', 'description']), [
      'name' => 'sometimes|required',
      'description' => 'sometimes|required',
    ]);

    if ($validator->fails()) {
      return ApiHelper::sendResponse(400, $validator->messages());
    }

    try {
      $data = $validator->validated();

      $createdCategory = $category->update($data);

      return ApiHelper::sendResponse(201, data: $createdCategory);
    } catch (Exception $e) {
      return ApiHelper::sendResponse(500, $e->getMessage());
    }
  }

  public function destroy(Category $category)
  {
    try {
      $category->delete();

      return ApiHelper::sendResponse(200);
    } catch (Exception $e) {
      return ApiHelper::sendResponse(500, $e->getMessage());
    }
  }   //
}
