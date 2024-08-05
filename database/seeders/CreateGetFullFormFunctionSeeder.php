<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateGetFullFormFunctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared('
            DROP FUNCTION IF EXISTS GetFullForm;
        ');

        DB::unprepared('
            CREATE FUNCTION GetFullForm(micrositeId INT)
            RETURNS JSON
            DETERMINISTIC
            READS SQL DATA
            BEGIN
                DECLARE result JSON;

                -- Inicializar el resultado como "not found"
                SET result = JSON_OBJECT("message", "not found");

                -- Obtener el formulario
                SELECT
                    JSON_OBJECT(
                        "id", f.id,
                        "microsite_id", f.microsite_id,
                        "created_at", f.created_at,
                        "updated_at", f.updated_at,
                        "fields", (
                            SELECT JSON_ARRAYAGG(
                                JSON_OBJECT(
                                    "id", ff.id,
                                    "name", ff.name,
                                    "description", ff.description,
                                    "url_img", ff.url_img,
                                    "value", ff.value,
                                    "is_required", ff.is_required,
                                    "type", ff.type,
                                    "created_at", ff.created_at,
                                    "updated_at", ff.updated_at,
                                    "options", (
                                        SELECT JSON_ARRAYAGG(
                                            JSON_OBJECT(
                                                "id", ffo.id,
                                                "name", ffo.name
                                            )
                                        )
                                        FROM form_field_options ffo
                                        WHERE ffo.form_field_id = ff.id
                                    )
                                )
                            )
                            FROM form_fields ff
                            WHERE ff.form_id = f.id
                        )
                    ) INTO result
                FROM forms f
                WHERE f.microsite_id = micrositeId;

                RETURN result;
            END;
        ');
    }
}
