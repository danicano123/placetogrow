<?php

namespace App\Domain\Forms\Services;

use App\Domain\Forms\Models\FormFieldOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FormFieldOptionService
{
    public function getFormFieldOptionById($id)
    {
        try {
            return FormFieldOption::findOrFail($id);
        } catch (\Exception $e) {
            Log::error('Error fetching form field option: ' . $e->getMessage());
            return ['message' => 'Form field option not found'];
        }
    }

    public function createFormFieldOption(Request $request)
    {
        try {
            return FormFieldOption::create($request->all());
        } catch (\Exception $e) {
            Log::error('Error creating form field option: ' . $e->getMessage());
        }
    }

    public function updateFormFieldOption($id, Request $request)
    {
        try {
            $formFieldOption = FormFieldOption::findOrFail($id);
            $formFieldOption->update($request->all());
            return $formFieldOption;
        } catch (\Exception $e) {
            Log::error('Error updating form field option: ' . $e->getMessage());
        }
    }

    public function deleteFormFieldOption($id)
    {
        try {
            $formFieldOption = FormFieldOption::findOrFail($id);
            $formFieldOption->delete();
            return response()->json(['message' => 'Form field option deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Error deleting form field option: ' . $e->getMessage());
        }
    }


    public function getFormFieldOptionsByFormFieldId($formFieldId)
    {
        try {
            return FormFieldOption::where('form_field_id', $formFieldId)->get();
        } catch (\Exception $e) {
            Log::error('Error fetching form field options: ' . $e->getMessage());
        }
    }
}
