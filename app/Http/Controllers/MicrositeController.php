<?php

namespace App\Http\Controllers;

use App\Http\Requests\Microsites\StoreMicrositeRequest;
use App\Services\MicrositeService;
use Illuminate\Http\Request;

class MicrositeController extends Controller
{
    protected $micrositeService;

    public function __construct(MicrositeService $micrositeService)
    {
        $this->micrositeService = $micrositeService;
    }

    public function index()
    {
        $microsites = $this->micrositeService->getAllMicrosites();
        return response()->json(compact('microsites'), 200);
    }

    public function show($id)
    {
        $microsite = $this->micrositeService->getMicrositeById($id);
        return response()->json(compact('microsite'), 200);
    }

    public function store(StoreMicrositeRequest $request)
    {
        $microsite = $this->micrositeService->createMicrosite($request);
        return response()->json(compact('microsite'), 201);
    }

    public function update(Request $request, $id)
    {
        $microsite = $this->micrositeService->updateMicrosite($id, $request);
        return response()->json(compact('microsite'), 200);
    }

    public function toggleIsActive($id)
    {
        $microsite = $this->micrositeService->toggleIsActive($id);
        return response()->json(compact('microsite'), 200);
    }

    public function getActiveMicrosites()
    {
        $microsites = $this->micrositeService->getActiveMicrosites();
        return response()->json(compact('microsites'), 200);
    }
}
