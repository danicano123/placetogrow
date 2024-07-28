<?php

namespace App\Domain\Microsites\Services;

use App\Domain\Microsites\Models\Microsite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MicrositeService
{
    public function getAllMicrosites()
    {
        try {
            return Microsite::all();
        } catch (\Exception $e) {
            Log::error('Error fetching all microsites: ' . $e->getMessage());
        }
    }

    public function getMicrositeById($id)
    {
        try {
            return Microsite::findOrFail($id);
        } catch (\Exception $e) {
            Log::error('Error fetching microsite by ID: ' . $e->getMessage());
        }
    }

    public function createMicrosite(Request $request)
    {
        try {
            return Microsite::create($request->all());
        } catch (\Exception $e) {
            Log::error('Error creating microsite: ' . $e->getMessage());
        }
    }

    public function updateMicrosite($id, Request $request)
    {
        try {
            $microsite = Microsite::findOrFail($id);
            $microsite->update($request->all());
            return $microsite;
        } catch (\Exception $e) {
            Log::error('Error updating microsite: ' . $e->getMessage());
        }
    }

    public function toggleIsActive($id)
    {
        try {
            $microsite = Microsite::findOrFail($id);
            $microsite->update(['is_active' => !$microsite->is_active]);
            return $microsite;
        } catch (\Exception $e) {
            Log::error('Error toggling microsite status: ' . $e->getMessage());
        }
    }

    public function getActiveMicrosites()
    {
        try {
            return Microsite::where('is_active', true)->get();
        } catch (\Exception $e) {
            Log::error('Error fetching active microsites: ' . $e->getMessage());
        }
    }
}
