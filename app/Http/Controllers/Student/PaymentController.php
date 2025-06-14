<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Penting untuk debugging
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Midtrans\Transaction;

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

        // Buat record payment dengan status 'pending'
        $payment = Payment::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'amount' => $package->price,
            'status' => 'pending',
        ]);
        
        // Simpan ID pembayaran ke session untuk digunakan nanti
        session(['last_payment_id' => $payment->id]);

        $params = [
            'transaction_details' => [
                'order_id' => $payment->id . '-' . time(),
                'gross_amount' => $package->price,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'enabled_payments' => ['gopay', 'shopeepay', 'bca_va', 'bni_va', 'bri_va'],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return view('student.payments.checkout', compact('snapToken', 'package'));
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memproses pembayaran. Silakan coba lagi.');
        }
    }

    /**
     * Halaman ini dipanggil setelah user selesai di popup Midtrans.
     * Di sinilah kita akan mengecek status secara manual.
     */
    public function success(Request $request)
    {
        $paymentId = session('last_payment_id');
        if (!$paymentId) {
             return redirect()->route('siswa.dashboard')->with('error', 'Sesi pembayaran tidak ditemukan.');
        }
        
        $payment = Payment::find($paymentId);

        if ($payment && $payment->status === 'pending') {
            try {
                // Gunakan order_id yang sama dengan yang dikirim ke Midtrans
                $orderId = $payment->id . '-' . $payment->created_at->timestamp;
                
                $statusResponse = Transaction::status($orderId);

                // --- LOGIKA BARU YANG LEBIH KUAT ---
                // Paksa konversi respons menjadi array untuk konsistensi
                $status = json_decode(json_encode($statusResponse), true);

                // Sekarang, kita bisa dengan aman mengaksesnya sebagai array
                if (isset($status['transaction_status']) && ($status['transaction_status'] == 'settlement' || $status['transaction_status'] == 'capture')) {
                    $this->activateSubscription($payment);
                }
                // --- AKHIR LOGIKA BARU ---

            } catch (\Exception $e) {
                // Catat error ke log untuk investigasi jika masih terjadi masalah
                Log::error('Midtrans status check failed: ' . $e->getMessage());
            }
        }

        session()->forget('last_payment_id');

        return view('student.payments.success');
    }

    /**
     * Method ini tetap ada untuk menangani webhook jika nanti di-deploy online.
     */
    public function callback(Request $request)
    {
        try {
            $notification = new Notification();
            
            $orderIdParts = explode('-', $notification->order_id);
            $paymentId = $orderIdParts[0];
            $payment = Payment::find($paymentId);

            if ($payment && $payment->status === 'pending') {
                 if ($notification->transaction_status == 'settlement' || $notification->transaction_status == 'capture') {
                    $this->activateSubscription($payment);
                }
            }
        } catch (\Exception $e) {
             Log::error('Midtrans Webhook Error: ' . $e->getMessage());
        }
    }

    /**
     * Helper function untuk mengaktifkan langganan.
     */
    private function activateSubscription(Payment $payment)
    {
        // Pastikan kita tidak memproses ulang
        if ($payment->status !== 'pending') {
            return;
        }

        $payment->update(['status' => 'success']);

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
    }
}
