<?php

namespace App\Domain\Forms\Controllers;

use App\Domain\Forms\Services\FormFieldOptionService;
use Illuminate\Http\Request;

class FormFieldOptionController
{
    protected $formFieldOptionService;

    public function __construct(FormFieldOptionService $formFieldOptionService)
    {
        $this->formFieldOptionService = $formFieldOptionService;
    }

    public function show($id)
    {
        try {
            $formFieldOption = $this->formFieldOptionService->getFormFieldOptionById($id);
            return response()->json(compact('formFieldOption'), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Form field option not found'], 404);
        }
    }

    public function showByFormFieldId($formFieldId)
    {
        try {
            $formFieldOptions = $this->formFieldOptionService->getFormFieldOptionsByFormFieldId($formFieldId);
            return response()->json(compact('formFieldOptions'), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'not found'], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $formFieldOption = $this->formFieldOptionService->createFormFieldOption($request);
            return response()->json(compact('formFieldOption'), 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'not found'], 404);
        }
    }

    public function update(Request $request, $formFieldOptionId)
    {
        try {
            $formFieldOption = $this->formFieldOptionService->updateFormFieldOption($formFieldOptionId, $request);
            return response()->json(compact('formFieldOption'), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'not found'], 404);
        }
    }

    public function destroy($formFieldOptionId)
    {
        try {
            $this->formFieldOptionService->deleteFormFieldOption($formFieldOptionId);
            return response()->json(['message' => 'Form field option deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'not found'], 404);
        }
    }
}
