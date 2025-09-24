<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use App\Models\Booking;
use App\Models\Payment;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function createTransaction(Booking $booking)
    {
        $orderId = 'PLG-' . $booking->id . '-' . time();
        
        // Buat atau update payment record
        $payment = Payment::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'transaction_id' => uniqid(),
                'order_id' => $orderId,
                'amount' => $booking->total_amount,
                'status' => 'pending'
            ]
        );

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $booking->total_amount,
            ],
            'customer_details' => [
                'first_name' => $booking->customer_name,
                'email' => $booking->customer_email,
                'phone' => $booking->customer_phone,
            ],
            'item_details' => $this->getItemDetails($booking),
            'callbacks' => [
                'finish' => route('payment.finish', $booking->booking_code)
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return [
                'snap_token' => $snapToken,
                'order_id' => $orderId,
                'payment' => $payment
            ];
        } catch (\Exception $e) {
            throw new \Exception('Error creating payment: ' . $e->getMessage());
        }
    }

    private function getItemDetails(Booking $booking)
    {
        $items = [];
        
        foreach ($booking->bookingItems as $item) {
            $items[] = [
                'id' => $item->ticket->id,
                'price' => (int) $item->price,
                'quantity' => $item->quantity,
                'name' => $item->ticket->name,
                'category' => 'Tiket Masuk'
            ];
        }

        return $items;
    }

    public function handleNotification()
    {
        $notification = new Notification();
        
        $orderId = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status ?? null;
        
        $payment = Payment::where('order_id', $orderId)->first();
        
        if (!$payment) {
            return ['status' => 'error', 'message' => 'Payment not found'];
        }

        $booking = $payment->booking;

        // Update payment record
        $payment->update([
            'midtrans_transaction_id' => $notification->transaction_id,
            'midtrans_transaction_status' => $transactionStatus,
            'midtrans_response' => $notification->getResponse(),
            'payment_method' => $notification->payment_type ?? null,
        ]);

        // Handle different transaction status
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $payment->update(['status' => 'challenge']);
            } else if ($fraudStatus == 'accept') {
                $this->markAsPaid($payment, $booking);
            }
        } else if ($transactionStatus == 'settlement') {
            $this->markAsPaid($payment, $booking);
        } else if ($transactionStatus == 'pending') {
            $payment->update(['status' => 'pending']);
        } else if (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $payment->update(['status' => $transactionStatus]);
            $booking->update(['payment_status' => 'failed']);
        }

        return ['status' => 'success', 'message' => 'Notification handled'];
    }

    private function markAsPaid(Payment $payment, Booking $booking)
    {
        $payment->update([
            'status' => 'settlement',
            'paid_at' => now()
        ]);

        $booking->update([
            'payment_status' => 'paid',
            'status' => 'confirmed'
        ]);
    }
}