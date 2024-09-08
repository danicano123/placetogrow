<?php

namespace App\Domain\Payments\Controllers;

use App\Domain\Payments\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function show($id)
    {
        try {
            $payment = $this->paymentService->getPaymentDetails($id);
            return response()->json($payment, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'not found'], 404);
        }
    }

    public function getPaymentsByDocument($document)
    {
        try {
            $payments = $this->paymentService->getPaymentsByDocument($document);
            return response()->json($payments, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'not found'], 404);
        }
    }

    public function getPaymentsByMicrosite($micrositeId)
    {
        try {
            $payments = $this->paymentService->getPaymentsByMicrosite($micrositeId);
            return response()->json($payments, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'not found'], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $payment = $this->paymentService->createPayment($request);
            return response()->json(compact('payment'), 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $payment = $this->paymentService->updatePayment($id, $request);
            return response()->json(compact('payment'), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'not found'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $this->paymentService->deletePayment($id);
            return response()->json(['message' => 'Payment deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'not found'], 404);
        }
    }
}
