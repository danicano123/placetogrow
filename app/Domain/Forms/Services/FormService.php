<?php

namespace App\Domain\Forms\Services;

use App\Domain\Forms\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class FormService
{
    public function getFullForm(int $formId): array
    {
        try {
            // Ejecuta la función almacenada y obtiene el resultado como JSON
            $result = DB::select('SELECT GetFullForm(?) AS form', [$formId]);

            // Devuelve el resultado como un array
            return json_decode($result[0]->form, true);
        } catch (\Exception $e) {
            Log::error('Error fetching full form: ' . $e->getMessage());
            return ['message' => 'Error fetching full form'];
        }
    }

    public function createForm(Request $request)
    {
        try {
            return Form::create($request->all());
        } catch (\Exception $e) {
            Log::error('Error creating form: ' . $e->getMessage());
        }
    }

    public function updateForm($id, Request $request)
    {
        try {
            $form = Form::findOrFail($id);
            $form->update($request->all());
            return $form;
        } catch (\Exception $e) {
            Log::error('Error updating form: ' . $e->getMessage());
        }
    }

    public function deleteForm($id)
    {
        try {
            $form = Form::findOrFail($id);
            $form->delete();
            return response()->json(['message' => 'Form deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Error deleting form: ' . $e->getMessage());
        }
    }
}
