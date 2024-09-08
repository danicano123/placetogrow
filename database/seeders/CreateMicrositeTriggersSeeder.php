<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateMicrositeTriggersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Drop triggers if they exist
        DB::unprepared('DROP TRIGGER IF EXISTS after_microsite_insert;');

        // Create trigger for creating a form after inserting a microsite
        DB::unprepared('
            CREATE TRIGGER after_microsite_insert
            AFTER INSERT ON microsites
            FOR EACH ROW
            BEGIN
                DECLARE formId INT;
                DECLARE fieldId INT;

                -- Crear el formulario asociado al micrositio
                INSERT INTO forms (microsite_id, created_at, updated_at)
                VALUES (NEW.id, NOW(), NOW());

                -- Obtener el id del formulario recién creado
                SET formId = LAST_INSERT_ID();

                -- Crear campos del formulario
                INSERT INTO form_fields (form_id, name, is_required, type, created_at, updated_at)
                VALUES (formId, "Document Type", true, "select", NOW(), NOW());

                -- Obtener el id del campo "Document Type"
                SET fieldId = LAST_INSERT_ID();

                -- Crear opciones del campo "Document Type"
                INSERT INTO form_field_options (form_field_id, name)
                VALUES (fieldId, "CC"), (fieldId, "NIT"), (fieldId, "PPN"), (fieldId, "CE"), (fieldId, "RUT");

                -- Crear el campo "Document"
                INSERT INTO form_fields (form_id, name, is_required, type, created_at, updated_at)
                VALUES (formId, "Document", true, "number", NOW(), NOW());
            END;
        ');
    }
}
