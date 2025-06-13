<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans dari .env
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function checkout(Request $request)
    {
        $request->validate(['package_id' => 'required|exists:packages,id']);
        $package = Package::findOrFail($request->package_id);
        $user = Auth::user();

        // 1. Buat record payment di database dengan status 'pending'
        $payment = Payment::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'amount' => $package->price,
            'status' => 'pending',
        ]);

        // 2. Siapkan parameter untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $payment->id . '-' . time(), // Order ID unik
                'gross_amount' => $package->price,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'enabled_payments' => ['gopay', 'shopeepay', 'bca_va', 'bni_va', 'bri_va', 'credit_card'],
        ];

        try {
            // 3. Dapatkan Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($params);
            return view('student.payments.checkout', compact('snapToken', 'package'));

        } catch (\Exception $e) {
            // Tangani error jika gagal membuat token
            return redirect()->back()->with('error', 'Gagal memproses pembayaran. Silakan coba lagi.');
        }
    }

    public function callback(Request $request)
    {
        $notification = new Notification();

        $transactionStatus = $notification->transaction_status;
        $paymentType = $notification->payment_type;
        $orderId = $notification->order_id;
        $fraudStatus = $notification->fraud_status;
        
        // Ekstrak ID payment dari order_id
        $paymentId = explode('-', $orderId)[0];
        $payment = Payment::find($paymentId);

        if (!$payment) {
            return; // Payment tidak ditemukan
        }

        // Jangan proses jika status sudah success atau failed
        if ($payment->status === 'success' || $payment->status === 'failed') {
            return;
        }

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            // Jika pembayaran berhasil
            $payment->update(['status' => 'success']);

            // Buat atau perpanjang langganan
            $package = $payment->package;
            $user = $payment->user;

            $currentSubscription = Subscription::where('user_id', $user->id)->where('end_date', '>=', now())->first();
            
            $startDate = $currentSubscription ? $currentSubscription->end_date : now();
            
            Subscription::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'package_id' => $package->id,
                    'start_date' => $startDate,
                    'end_date' => \Carbon\Carbon::parse($startDate)->addMonths($package->duration_in_months)
                ]
            );

        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $payment->update(['status' => 'failed']);
        } else if ($transactionStatus == 'pending') {
            $payment->update(['status' => 'pending']);
        }
    }

    public function success()
    {
        return view('student.payments.success');
    }
}