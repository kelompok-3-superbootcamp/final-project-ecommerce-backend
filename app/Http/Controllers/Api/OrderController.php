<?php

namespace App\Http\Controllers\Api;

use App\Enum\PaymentStatus;
use App\Helper\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Order;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class OrderController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth')->except(['index', 'show']);
  }

  /**
   * Get orders
   *
   * @OA\Get(
   *     path="/api/orders",
   *     tags={"orders"},
   *     description="Get orders",
   *     operationId="index_orders",
   *     @OA\Response(
   *         response="200",
   *         description="Successful get data orders",
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
    return ApiHelper::sendResponse(data: Order::all());
  }

  /**
   * Get all ordered cars based on payment_status
   *
   * @OA\Get(
   *     path="/api/orders/user/{status}",
   *     tags={"orders"},
   *     description="Get all ordered cars based on payment_status",
   *     operationId="getOrderedCarsBasedOnPaymentStatus",
   *     security={{ "bearerAuth": {} }},
   *     @OA\Parameter(
   *         description="Parameter payment_status",
   *         in="path",
   *         name="status",
   *         required=true,
   *         @OA\Schema(type="string"),
   *         @OA\Examples(example="pending", value="pending", summary="Parameter payment status (complete|pending|error|closed)"),
   *     ),
   *     @OA\Response(
   *         response="200",
   *         description="Successful get data ordered cars",
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
  public function userOrders(string $status)
  {
    $orderedCars = DB::table('orders as o')
      ->join('cars as c', 'c.id', 'o.car_id')
      ->join('users as u', 'u.id', 'o.user_id')
      ->where('o.payment_status', $status)
      ->where('u.id', auth()->user()->id)
      ->select(
        'c.id',
        'o.payment_status',
        'c.name',
        'c.description',
        'c.price',
        'c.transmission',
        'c.condition',
        'c.image',
        'c.created_at',
        'c.updated_at',
      )->get();

    return ApiHelper::sendResponse(data: $orderedCars);
  }

  /**
   * Get all ordered cars based on current seller
   *
   * @OA\Get(
   *     path="/api/orders/seller",
   *     tags={"orders"},
   *     description="Get all ordered cars based on current seller",
   *     operationId="getOrderedCarsBasedOnSeller",
   *     security={{ "bearerAuth": {} }},
   *     @OA\Response(
   *         response="200",
   *         description="Successful get data ordered cars",
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
  public function sellerOrderLists()
  {
    $orders = DB::table('orders as o')
      ->join('cars as c', 'c.id', 'o.car_id')
      ->join('users as u', 'u.id', 'o.user_id')
      ->where('u.id', auth()->user()->id)
      ->select(
        'c.id',
        'o.payment_status',
        'c.name',
        'c.description',
        'c.price',
        'c.transmission',
        'c.condition',
        'c.image',
        'c.created_at',
        'c.updated_at',
      )->get();

    return ApiHelper::sendResponse(data: $orders);
  }

  /**
   * Get order detail
   *
   * @OA\Get(
   *     path="/api/orders/{id}",
   *     tags={"orders"},
   *     description="Get order detail",
   *     operationId="show_orders",
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
   *         description="Successful get data order",
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
  public function show(Order $order)
  {
    return ApiHelper::sendResponse(data: $order);
  }

  /**
   * Create order
   *
   * @OA\Post(
   *     path="/api/orders",
   *     tags={"orders"},
   *     description="Create new order",
   *     operationId="store_orders",
   *     security={{ "bearerAuth": {} }},
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             type="object",
   *             @OA\Property(property="car_id", type="integer"),
   *         )
   *     ),
   *     @OA\Response(
   *        response=400,
   *        description="Validation Error",
   *     ),
   *     @OA\Response(
   *         response="200",
   *         description="Successful add data types",
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
      'car_id',
    ]), [
      'car_id' => 'required|exists:cars,id',
    ]);

    if ($validator->fails()) {
      return ApiHelper::sendResponse(400, $validator->messages());
    }

    try {
      $data = $validator->validated();
      $car = Car::findOrFail($data['car_id']);

      if ($car->stock <= 0) {
        return ApiHelper::sendResponse(404, data: "Out of stock");
      }

      $createdOrder = Order::create([
        'date' => Carbon::now(),
        'payment_method' => 'midtrans',
        'payment_status' => 'pending',
        'payment_url' => 'none',
        'total_price' => $car->price,
        'car_id' => $data['car_id'],
        'user_id' => auth()->user()->id
      ]);

      return ApiHelper::sendResponse(201, data: $createdOrder);
    } catch (Exception $e) {
      return ApiHelper::sendResponse(500, $e->getMessage());
    }
  }


  /**
   * Edit orders
   *
   * @OA\Put(
   *     path="/api/orders/{id}",
   *     tags={"orders"},
   *     description="Edit orders",
   *     operationId="update_orders",
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
   *             @OA\Property(property="date", type="string"),
   *             @OA\Property(property="payment_method", type="string"),
   *             @OA\Property(property="payment_status", type="string"),
   *             @OA\Property(property="payment_url", type="string"),
   *             @OA\Property(property="total_price", type="integer"),
   *             @OA\Property(property="car_id", type="integer"),
   *         )
   *     ),
   *     @OA\Response(
   *        response=400,
   *        description="Validation Error",
   *     ),
   *     @OA\Response(
   *         response="200",
   *         description="Successful add data types",
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
  public function update(Request $request, Order $order)
  {
    $validator = Validator::make($request->only([
      'date',
      'payment_method',
      'payment_status',
      'payment_url',
      'total_price',
      'car_id',
    ]), [
      'date' => 'sometimes|required|date_format:Y-m-d H:i:s',
      'payment_method' => 'sometimes|required',
      'payment_status' => ['sometimes', 'required', new Enum(PaymentStatus::class)],
      'payment_url' => 'sometimes|required',
      'total_price' => 'sometimes|required|numeric',
      'car_id' => 'sometimes|required|exists:cars,id',
    ]);

    if ($validator->fails()) {
      return ApiHelper::sendResponse(400, $validator->messages());
    }

    try {
      DB::transaction(function () use ($validator, $order) {
        $data = $validator->validated();
        $data['user_id'] = auth()->user()->id;

        $updatedOrder = $order->update($data);

        if ($data['payment_status'] === PaymentStatus::COMPLETE) {
          DB::table('cars')->where('id', $order->car_id)->decrement('stock');
        }

        return ApiHelper::sendResponse(201, data: $updatedOrder);
      });
    } catch (Exception $e) {
      return ApiHelper::sendResponse(500, $e->getMessage());
    }
  }


  /**
   * Checkout order
   *
   * @OA\Post(
   *     path="/api/orders/checkout/{id}",
   *     tags={"orders"},
   *     description="Checkout order",
   *     operationId="checkout_orders",
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
   *         description="Successful checkout order",
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
  public function checkout(Order $order)
  {
    if ($order->payment_method == 'midtrans') {
      // Call Midtrans API
      \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
      \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
      \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
      \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');

      try {
        DB::transaction(function () use ($order) {
          // Create Midtrans Params
          $midtransParams = [
            'transaction_details' => [
              'order_id' => $order->id,
              'gross_amount' => (int) $order->total_price,
            ],
            'customer_details' => [
              'first_name' => auth()->user()->id,
              'email' => auth()->user()->email,
            ],
            'enabled_payments' => ['gopay', 'bank_transfer'],
            'vtweb' => []
          ];

          // Get Snap Payment Page URL
          $paymentUrl = \Midtrans\Snap::createTransaction($midtransParams)->redirect_url;


          $order->payment_url = $paymentUrl;
          // Decrement stock
          DB::table('cars')->where('id', $order->car_id)->decrement('stock');
          $order->save();


          return ApiHelper::sendResponse(201, data: $order);
        });
      } catch (Exception $e) {
        return ApiHelper::sendResponse(500, $e->getMessage());
      }
    }
  }

  /**
   * Delete orders
   *
   * @OA\Delete(
   *     path="/api/orders/{id}",
   *     tags={"orders"},
   *     description="Delete orders",
   *     operationId="destroy_orders",
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
   *         description="Successful delete data order",
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
  public function destroy(Order $order)
  {
    try {
      $order->delete();

      return ApiHelper::sendResponse(200);
    } catch (Exception $e) {
      return ApiHelper::sendResponse(500, $e->getMessage());
    }
  }
}
