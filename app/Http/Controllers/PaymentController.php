<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MidtransService;
use App\Models\Booking;
use App\Models\Payment;

class PaymentController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

   public function pay($booking_code)
{
    try {
        $booking = Booking::with('bookingItems.ticket')
            ->where('booking_code', $booking_code)
            ->firstOrFail();

        if ($booking->payment_status === 'paid') {
            return redirect()->route('booking.success', $booking_code)
                ->with('info', 'Booking ini sudah dibayar.');
        }

        // BYPASS MIDTRANS UNTUK SEMENTARA - DEBUGGING
        // Buat payment record manual
        $payment = \App\Models\Payment::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'transaction_id' => uniqid(),
                'order_id' => 'TEST-' . $booking->id . '-' . time(),
                'amount' => $booking->total_amount,
                'status' => 'pending'
            ]
        );

        return view('payment.checkout', [
            'booking' => $booking,
            'snapToken' => 'test-token-debug',
            'clientKey' => config('midtrans.client_key')
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Payment error: ' . $e->getMessage());
        return redirect()->route('booking.success', $booking_code)
            ->with('error', 'Error: ' . $e->getMessage());
    }
}
    // } catch (\Exception $e) {
    //     \Log::error('Payment error: ' . $e->getMessage());
    //     \Log::error('Stack trace: ' . $e->getTraceAsString());

//         return redirect()->route('booking.success', $booking_code)
//             ->with('error', 'Error: ' . $e->getMessage());
//     }
// }

    // try {
    //     $paymentData = $this->midtransService->createTransaction($booking);
        
    //     return view('payment.checkout', [
    //         'booking' => $booking,
    //         'snapToken' => $paymentData['snap_token'],
    //         'clientKey' => config('midtrans.client_key')
    //     ]);
        
//     } catch (\Exception $e) {
//         return redirect()->route('booking.success', $booking_code)
//             ->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
//     }
// }

//     public function finish(Request $request, $booking_code)
//     {
//         $booking = Booking::where('booking_code', $booking_code)->firstOrFail();
        
//         return view('payment.finish', compact('booking'));
//     }

//     public function webhook(Request $request)
//     {
//         try {
//             $result = $this->midtransService->handleNotification();
//             return response()->json($result);
//         } catch (\Exception $e) {
//             return response()->json([
//                 'status' => 'error',
//                 'message' => $e->getMessage()
//             ], 500);
//         }
//     }

//     public function checkStatus($booking_code)
//     {
//         $booking = Booking::with('payment')
//             ->where('booking_code', $booking_code)
//             ->firstOrFail();

//         return response()->json([
//             'booking_status' => $booking->status,
//             'payment_status' => $booking->payment_status,
//             'payment_details' => $booking->payment
//         ]);
//     }
}