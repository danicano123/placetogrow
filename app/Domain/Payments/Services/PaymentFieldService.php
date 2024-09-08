<?php

namespace App\Domain\Payments\Services;

use App\Domain\Payments\Models\PaymentField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentFieldService
{
    public function createPaymentField(Request $request)
    {
        try {
            return PaymentField::create($request->all());
        } catch (\Exception $e) {
            Log::error('Error creating payment field: ' . $e->getMessage());
        }
    }

    public function updatePaymentField($id, Request $request)
    {
        try {
            $paymentField = PaymentField::findOrFail($id);
            $paymentField->update($request->all());
            return $paymentField;
        } catch (\Exception $e) {
            Log::error('Error updating payment field: ' . $e->getMessage());
        }
    }

    public function deletePaymentField($id)
    {
        try {
            $paymentField = PaymentField::findOrFail($id);
            $paymentField->delete();
            return response()->json(['message' => 'Payment field deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Error deleting payment field: ' . $e->getMessage());
        }
    }
}
