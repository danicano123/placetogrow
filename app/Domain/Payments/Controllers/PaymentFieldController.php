<?php

namespace App\Domain\Payments\Controllers;

use App\Domain\Payments\Services\PaymentFieldService;
use Illuminate\Http\Request;

class PaymentFieldController
{
    protected $paymentFieldService;

    public function __construct(PaymentFieldService $paymentFieldService)
    {
        $this->paymentFieldService = $paymentFieldService;
    }

    public function store(Request $request)
    {
        try {
            $paymentField = $this->paymentFieldService->createPaymentField($request);
            return response()->json(compact('paymentField'), 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'not found'], 404);
        }
    }

    public function update(Request $request, $paymentFieldId)
    {
        try {
            $paymentField = $this->paymentFieldService->updatePaymentField($paymentFieldId, $request);
            return response()->json(compact('paymentField'), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'not found'], 404);
        }
    }

    public function destroy($paymentFieldId)
    {
        try {
            $this->paymentFieldService->deletePaymentField($paymentFieldId);
            return response()->json(['message' => 'Payment field deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'not found'], 404);
        }
    }
}
