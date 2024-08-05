<?php

namespace App\Domain\Forms\Controllers;

use App\Domain\Forms\Services\FormService;
use Illuminate\Http\Request;

class FormController
{
    protected $formService;

    public function __construct(FormService $formService)
    {
        $this->formService = $formService;
    }

    public function show($id)
    {
        try {
            $form = $this->formService->getFullForm($id);
            return response()->json($form, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'not found'], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $form = $this->formService->createForm($request);
            return response()->json(compact('form'), 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $form = $this->formService->updateForm($id, $request);
            return response()->json(compact('form'), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'not found'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $this->formService->deleteForm($id);
            return response()->json(['message' => 'Form deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'not found'], 404);
        }
    }
}
