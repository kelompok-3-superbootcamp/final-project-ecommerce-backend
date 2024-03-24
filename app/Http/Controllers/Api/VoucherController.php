<?php

namespace App\Http\Controllers\Api;

use App\Enum\DiscountType;
use App\Helper\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Middleware\IsAdmin;
use App\Models\Voucher;
use App\Rules\DiscountValueValidation;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class VoucherController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth', IsAdmin::class])->except(['index', 'show', 'verifyVoucherCode']);
  }

  /**
   * Get voucher
   *
   * @OA\Get(
   *     path="/api/vouchers",
   *     tags={"vouchers"},
   *     description="Get vouchers",
   *     operationId="index_vouchers",
   *     @OA\Response(
   *         response="200",
   *         description="Successful get data vouchers",
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
    return ApiHelper::sendResponse(data: Voucher::all());
  }


  /**
   * Get single voucher
   *
   * @OA\Get(
   *     path="/api/vouchers/{id}",
   *     tags={"vouchers"},
   *     description="Get single voucher",
   *     operationId="show_vouchers",
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
   *         description="Successful get single voucher",
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
  public function show(Voucher $voucher)
  {
    return ApiHelper::sendResponse(data: $voucher);
  }

  /**
   * Verify voucher code
   *
   * @OA\Post(
   *     path="/api/vouchers/verify",
   *     tags={"vouchers"},
   *     description="Verify voucher code",
   *     operationId="verify_vouchers",
   *     security={{ "bearerAuth": {} }},
   *     @OA\RequestBody(
   *         @OA\JsonContent(
   *             type="object",
   *             @OA\Property(property="voucher_code", type="string"),
   *             @OA\Property(property="order_id", type="string")
   *         )
   *     ),
   *     @OA\Response(
   *         response="200",
   *         description="Successful verify voucher code",
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
  public function verifyVoucherCode(Request $request)
  {
    $validator = Validator::make($request->only(['voucher_code', 'order_id']), [
      'order_id' => 'required|exists:orders,id',
      'voucher_code' => 'required|exists:vouchers,voucher_code'
    ]);

    if ($validator->fails()) {
      return ApiHelper::sendResponse(400, 'Wrong voucher code, try again');
    }

    try {
      $data = $validator->validated();

      $voucher = DB::table('vouchers')
        ->where('voucher_code', $data['voucher_code'])
        ->first();

      if (is_null($voucher)) {
        return ApiHelper::sendResponse(message: 'Voucher not found');
      }

      $isExpired = Carbon::parse($voucher->expired_at)->isPast();
      $isRanOut = $voucher->quota === 0;

      if ($isExpired) return ApiHelper::sendResponse(message: 'Voucher expired');
      if ($isRanOut) return ApiHelper::sendResponse(message: 'Ran out of vouchers');

      $order = DB::table('orders')->find($data['order_id']);

      switch ($voucher->discount_type) {
        case 'percentage':
          $order->total_price = $order->total_price - ($order->total_price * $voucher->discount_value / 100);
          break;
        case 'nominal':
          $order->total_price = $order->total_price - $voucher->discount_value;
          break;
        default:
          break;
      }

      return ApiHelper::sendResponse(data: ['voucher' => $voucher, 'total_price' => $order->total_price]);
    } catch (Exception $e) {
      return ApiHelper::sendResponse(500, $e->getMessage());
    }
  }


  /**
   * Add a new Vouchers
   *
   * @OA\Post(
   *     path="/api/vouchers",
   *     tags={"vouchers"},
   *     description="Add a new vouchers",
   *     operationId="store_vouchers",
   *     security={{ "bearerAuth": {} }},
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             type="object",
   *             @OA\Property(property="voucher_code", type="string"),
   *             @OA\Property(property="discount_value", type="string"),
   *             @OA\Property(property="discount_type", type="string"),
   *             @OA\Property(property="quota", type="integer"),
   *             @OA\Property(property="expired_at", type="string"),
   *         )
   *     ),
   *     @OA\Response(
   *        response=400,
   *        description="Validation Error",
   *        @OA\JsonContent(
   *           @OA\Property(property="status", type="integer", example="400"),
   *           @OA\Property(property="message", type="object",
   *           ),
   *        ),
   *     ),
   *     @OA\Response(
   *         response="200",
   *         description="Successful add new vouchers",
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
      'voucher_code',
      'discount_value',
      'discount_type',
      'quota',
      'expired_at'
    ]), [
      'voucher_code' => 'required|min:5',
      'discount_value' => ['required', 'numeric', new DiscountValueValidation],
      'discount_type' => ['required', new Enum(DiscountType::class)],
      'quota' => 'required|numeric',
      'expired_at' => 'required|date_format:Y-m-d H:i:s'
    ]);

    if ($validator->fails()) {
      return ApiHelper::sendResponse(400, $validator->messages());
    }

    try {
      $data = $validator->validated();

      $createdVoucher = Voucher::create($data);

      return ApiHelper::sendResponse(201, data: $createdVoucher);
    } catch (Exception $e) {
      return ApiHelper::sendResponse(500, $e->getMessage());
    }
  }


  /**
   * Edit voucher
   *
   * @OA\Put(
   *     path="/api/vouchers/{id}",
   *     tags={"vouchers"},
   *     description="Edit voucher",
   *     operationId="update_voucher",
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
   *             @OA\Property(property="voucher_code", type="string"),
   *             @OA\Property(property="dicount_value", type="string"),
   *             @OA\Property(property="dicount_type", type="string"),
   *             @OA\Property(property="quota", type="integer"),
   *             @OA\Property(property="expired_at", type="string"),
   *         )
   *     ),
   *     @OA\Response(
   *        response=400,
   *        description="Validation Error",
   *        @OA\JsonContent(
   *           @OA\Property(property="status", type="integer", example="400"),
   *           @OA\Property(property="message", type="object",
   *           ),
   *        ),
   *     ),
   *     @OA\Response(
   *         response="200",
   *         description="Successful update voucher",
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
  public function update(Voucher $voucher, Request $request)
  {
    $validator = Validator::make($request->only([
      'voucher_code',
      'discount_value',
      'discount_type',
      'quota',
      'expired_at'
    ]), [
      'voucher_code' => 'sometimes|required',
      'discount_value' => ['sometimes', 'required', 'numeric', new DiscountValueValidation],
      'discount_type' => ['sometimes', 'required', new Enum(DiscountType::class)],
      'quota' => 'sometimes|required|numeric',
      'expired_at' => 'sometimes|required|date_format:Y-m-d H:i:s'
    ]);

    if ($validator->fails()) {
      return ApiHelper::sendResponse(400, $validator->messages());
    }

    try {
      $data = $validator->validated();

      $updatedVoucher = $voucher->update($data);

      return ApiHelper::sendResponse(201, data: $updatedVoucher);
    } catch (Exception $e) {
      return ApiHelper::sendResponse(500, $e->getMessage());
    }
  }


  /**
   * Delete voucher
   *
   * @OA\Delete(
   *     path="/api/vouchers/{id}",
   *     tags={"vouchers"},
   *     description="Delete vouchers",
   *     operationId="destroy_vouchers",
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
   *         description="Successful delete data voucher",
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
  public function destroy(Voucher $voucher)
  {
    try {
      $voucher->delete();

      return ApiHelper::sendResponse(200);
    } catch (Exception $e) {
      return ApiHelper::sendResponse(500, $e->getMessage());
    }
  }
}
