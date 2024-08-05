<?php

namespace App\Domain\Forms\Controllers;

use App\Domain\Forms\Services\FormFieldService;
use Illuminate\Http\Request;

class FormFieldController
{
    protected $formFieldService;

    public function __construct(FormFieldService $formFieldService)
    {
        $this->formFieldService = $formFieldService;
    }

    public function show($id)
    {
        try {
            $formField = $this->formFieldService->getFormFieldById($id);
            return response()->json(compact('formField'), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Form field not found'], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $formField = $this->formFieldService->createFormField($request);
            return response()->json(compact('formField'), 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'not found'], 404);
        }
    }

    public function update(Request $request, $formFieldId)
    {
        try {
            $formField = $this->formFieldService->updateFormField($formFieldId, $request);
            return response()->json(compact('formField'), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'not found'], 404);
        }
    }

    public function destroy($formFieldId)
    {
        try {
            $this->formFieldService->deleteFormField($formFieldId);
            return response()->json(['message' => 'Form field deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'not found'], 404);
        }
    }
}
