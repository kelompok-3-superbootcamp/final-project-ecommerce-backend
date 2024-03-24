<?php

namespace App\Http\Controllers\Api;

use Midtrans\Config;
use Midtrans\Notification;
use App\Http\Controllers\Controller;
use App\Models\Order;
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

    // Cari transaksi berdasarkan ID
    $order = Order::findOrFail(explode($orderId, '-')[1]);

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
  }
}
