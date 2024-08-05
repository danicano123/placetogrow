<?php

namespace App\Domain\Payments\Services;

use App\Domain\Payments\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public function getPaymentDetails(int $paymentId): array
    {
        try {
            // Ejecuta la función almacenada y obtiene el resultado como JSON
            $result = DB::select('SELECT GetPaymentDetails(?) AS payment', [$paymentId]);

            // Devuelve el resultado como un array
            return json_decode($result[0]->payment, true);
        } catch (\Exception $e) {
            Log::error('Error fetching payment details: ' . $e->getMessage());
            return ['message' => 'Error fetching payment details'];
        }
    }

    public function getPaymentsByDocument(string $document): array
    {
        try {
            // Ejecuta la función almacenada y obtiene el resultado como JSON
            $result = DB::select('SELECT GetPaymentsByDocument(?) AS payments', [$document]);

            // Devuelve el resultado como un array
            return json_decode($result[0]->payments, true);
        } catch (\Exception $e) {
            Log::error('Error fetching payments by document: ' . $e->getMessage());
            return ['message' => 'Error fetching payments by document'];
        }
    }

    public function getPaymentsByMicrosite(int $micrositeId): array
    {
        try {
            // Ejecuta la función almacenada y obtiene el resultado como JSON
            $result = DB::select('SELECT GetPaymentsByMicrosite(?) AS payments', [$micrositeId]);

            // Devuelve el resultado como un array
            return json_decode($result[0]->payments, true);
        } catch (\Exception $e) {
            Log::error('Error fetching payments by microsite: ' . $e->getMessage());
            return ['message' => 'Error fetching payments by microsite'];
        }
    }

    public function createPayment(Request $request)
    {
        try {
            return Payment::create($request->all());
        } catch (\Exception $e) {
            Log::error('Error creating payment: ' . $e->getMessage());
        }
    }

    public function updatePayment($id, Request $request)
    {
        try {
            $payment = Payment::findOrFail($id);
            $payment->update($request->all());
            return $payment;
        } catch (\Exception $e) {
            Log::error('Error updating payment: ' . $e->getMessage());
        }
    }

    public function deletePayment($id)
    {
        try {
            $payment = Payment::findOrFail($id);
            $payment->delete();
            return response()->json(['message' => 'Payment deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Error deleting payment: ' . $e->getMessage());
        }
    }
}
