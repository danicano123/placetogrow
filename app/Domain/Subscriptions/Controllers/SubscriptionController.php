<?php

namespace App\Domain\Subscriptions\Controllers;

use App\Domain\Subscriptions\Services\SubscriptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function index()
    {
        try {
            $subscriptions = $this->subscriptionService->getAllSubscriptions();
            return response()->json($subscriptions, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching subscriptions'], 500);
        }
    }

    public function getSubscriptionByUserIdAndMicrositeId($userId, $micrositeId): JsonResponse
    {
        try {
            $subscription = $this->subscriptionService->getSubscriptionByUserIdAndMicrositeId($userId, $micrositeId);
            if ($subscription) {
                return response()->json($subscription, 200);
            } else {
                return response()->json(['message' => 'Subscription not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching subscription'], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $subscription = $this->subscriptionService->createSubscription($request->all());
            return response()->json($subscription, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating subscription'], 500);
        }
    }

    public function destroy($token): JsonResponse
    {
        try {
            $deleted = $this->subscriptionService->deleteSubscriptionByToken($token);
            if ($deleted) {
                return response()->json(['message' => 'Subscription deleted successfully'], 200);
            } else {
                return response()->json(['message' => 'Subscription not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting subscription'], 500);
        }
    }
}
