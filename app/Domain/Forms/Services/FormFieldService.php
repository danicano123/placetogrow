<?php

namespace App\Domain\Forms\Services;

use App\Domain\Forms\Models\FormField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FormFieldService
{
    public function getFormFieldById($id)
    {
        try {
            $formField = FormField::findOrFail($id);
            return $formField;
        } catch (\Exception $e) {
            Log::error('Error fetching form field: ' . $e->getMessage());
            return response()->json(['message' => 'Form field not found'], 404);
        }
    }

    public function createFormField(Request $request)
    {
        try {
            return FormField::create($request->all());
        } catch (\Exception $e) {
            Log::error('Error creating form field: ' . $e->getMessage());
        }
    }

    public function updateFormField($id, Request $request)
    {
        try {
            $formField = FormField::findOrFail($id);
            $formField->update($request->all());
            return $formField;
        } catch (\Exception $e) {
            Log::error('Error updating form field: ' . $e->getMessage());
        }
    }

    public function deleteFormField($id)
    {
        try {
            $formField = FormField::findOrFail($id);
            $formField->delete();
            return response()->json(['message' => 'Form field deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Error deleting form field: ' . $e->getMessage());
        }
    }
}
