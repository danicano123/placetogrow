<?php

namespace App\Domain\Subscriptions\Services;

use App\Domain\Subscriptions\Models\Subscription;
use Illuminate\Support\Facades\Log;

class SubscriptionService
{
    public function getAllSubscriptions()
    {
        try {
            return Subscription::all();
        } catch (\Exception $e) {
            Log::error('Error fetching all subscriptions: ' . $e->getMessage());
        }
    }

    public function getSubscriptionByUserIdAndMicrositeId($userId, $micrositeId)
    {
        try {
            return Subscription::where('user_id', $userId)
                ->where('microsite_id', $micrositeId)
                ->first();
        } catch (\Exception $e) {
            Log::error('Error fetching subscription by user ID and microsite ID: ' . $e->getMessage());
            return null;
        }
    }

    public function createSubscription(array $data)
    {
        try {
            return Subscription::create($data);
        } catch (\Exception $e) {
            Log::error('Error creating subscription: ' . $e->getMessage());
            throw new \Exception('Error creating subscription');
        }
    }

    public function getSubscriptionById($id)
    {
        try {
            return Subscription::findOrFail($id);
        } catch (\Exception $e) {
            Log::error('Error fetching subscription by ID: ' . $e->getMessage());
        }
    }

    public function updateSubscription($id, array $data)
    {
        try {
            $subscription = Subscription::findOrFail($id);
            $subscription->update($data);
            return $subscription;
        } catch (\Exception $e) {
            Log::error('Error updating subscription: ' . $e->getMessage());
        }
    }

    public function deleteSubscriptionByToken($token)
    {
        try {
            $subscription = Subscription::where('token', $token)->firstOrFail();
            $subscription->delete();
            return true;
        } catch (\Exception $e) {
            Log::error('Error deleting subscription by token: ' . $e->getMessage());
            return false;
        }
    }
}
