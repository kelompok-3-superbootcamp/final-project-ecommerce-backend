<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiHelper;
use Midtrans\Config;
use Midtrans\Notification;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Exception;
use Illuminate\Support\Facades\DB;

class MidtransCallbackController extends Controller
{
  public function callback()
  {
    // Set konfigurasi midtrans
    Config::$serverKey = config('services.midtrans.serverKey');
    Config::$isProduction = config('services.midtrans.isProduction');
    Config::$isSanitized = config('services.midtrans.isSanitized');
    Config::$is3ds = config('services.midtrans.is3ds');

    // Buat instance midtrans notification
    $notification = new Notification();

    // Assign ke variable untuk memudahkan coding
    $status = $notification->transaction_status;
    $type = $notification->payment_type;
    $fraud = $notification->fraud_status;
    $orderId = $notification->order_id;

    $realOrderId = explode('-', $orderId);

    // Cari transaksi berdasarkan ID
    $order = Order::findOrFail($realOrderId[0]);

    // Handle notification status midtrans
    if ($status == 'capture') {
      if ($type == 'credit_card') {
        if ($fraud == 'challenge') {
          $order->payment_status = 'pending';
        } else {
          $order->payment_status = 'success';
        }
      }
    } elseif ($status == 'settlement') {
      $order->payment_status = 'success';
    } elseif ($status == 'pending') {
      $order->payment_status = 'pending';
    } elseif ($status == 'deny') {
      $order->payment_status = 'cancelled';
    } elseif ($status == 'expire') {
      $order->payment_status = 'cancelled';
    } elseif ($status == 'cancel') {
      $order->payment_status = 'cancelled';
    }


    try {
      DB::transaction(function () use ($order, $status) {
        if ($status === 'settlement') {
          DB::table('cars')->where('id', $order->car_id)->decrement('stock');
        }

        $order->save();
      });

      //return response
      return response()->json([
        'meta' => [
          'code' => 200,
          'message' => 'Midtrans Notification Success'
        ]
      ]);
    } catch (Exception $e) {
      return ApiHelper::sendResponse(500, $e->getMessage());
    }
  }
}
