<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreatePaymentFunctionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Eliminar funciones almacenadas si ya existen
        DB::unprepared('DROP FUNCTION IF EXISTS GetPaymentDetails;');
        DB::unprepared('DROP FUNCTION IF EXISTS GetPaymentsByDocument;');
        DB::unprepared('DROP FUNCTION IF EXISTS GetPaymentsByMicrosite;');

        // Crear las nuevas funciones almacenadas
        DB::unprepared('
            CREATE FUNCTION GetPaymentDetails(paymentId INT)
            RETURNS JSON
            DETERMINISTIC
            READS SQL DATA
            BEGIN
                DECLARE result JSON;

                -- Inicializar el resultado como "not found"
                SET result = JSON_OBJECT("message", "not found");

                -- Obtener el pago y sus campos
                SELECT
                    JSON_OBJECT(
                        "id", p.id,
                        "name", p.name,
                        "category", p.category,
                        "microsite_type", p.microsite_type,
                        "currency_type", p.currency_type,
                        "document_type", p.document_type,
                        "document", p.document,
                        "is_active", p.is_active,
                        "total_paid", p.total_paid,
                        "microsite_id", p.microsite_id,
                        "user_id", p.user_id,
                        "request_id", p.request_id,
                        "created_at", p.created_at,
                        "updated_at", p.updated_at,
                        "fields", (
                            SELECT JSON_ARRAYAGG(
                                JSON_OBJECT(
                                    "id", pf.id,
                                    "name", pf.name,
                                    "description", pf.description,
                                    "url_img", pf.url_img,
                                    "value", pf.value,
                                    "type", pf.type,
                                    "created_at", pf.created_at,
                                    "updated_at", pf.updated_at
                                )
                            )
                            FROM payment_fields pf
                            WHERE pf.payment_id = p.id
                        )
                    ) INTO result
                FROM payments p
                WHERE p.id = paymentId;

                RETURN result;
            END;
        ');

        DB::unprepared('
            CREATE FUNCTION GetPaymentsByDocument(document VARCHAR(50))
            RETURNS JSON
            DETERMINISTIC
            READS SQL DATA
            BEGIN
                DECLARE result JSON;

                -- Inicializar el resultado como una lista vacía
                SET result = JSON_ARRAY();

                -- Obtener los pagos y sus campos
                SELECT
                    JSON_ARRAYAGG(
                        JSON_OBJECT(
                            "id", p.id,
                            "name", p.name,
                            "category", p.category,
                            "microsite_type", p.microsite_type,
                            "currency_type", p.currency_type,
                            "document_type", p.document_type,
                            "document", p.document,
                            "is_active", p.is_active,
                            "total_paid", p.total_paid,
                            "microsite_id", p.microsite_id,
                            "user_id", p.user_id,
                            "request_id", p.request_id,
                            "created_at", p.created_at,
                            "updated_at", p.updated_at,
                            "fields", (
                                SELECT JSON_ARRAYAGG(
                                    JSON_OBJECT(
                                        "id", pf.id,
                                        "name", pf.name,
                                        "description", pf.description,
                                        "url_img", pf.url_img,
                                        "value", pf.value,
                                        "type", pf.type,
                                        "created_at", pf.created_at,
                                        "updated_at", pf.updated_at
                                    )
                                )
                                FROM payment_fields pf
                                WHERE pf.payment_id = p.id
                            )
                        )
                    ) INTO result
                FROM payments p
                WHERE p.user_id = document;

                RETURN result;
            END;
        ');

        DB::unprepared('
            CREATE FUNCTION GetPaymentsByMicrosite(micrositeId INT)
            RETURNS JSON
            DETERMINISTIC
            READS SQL DATA
            BEGIN
                DECLARE result JSON;

                -- Inicializar el resultado como una lista vacía
                SET result = JSON_ARRAY();

                -- Obtener los pagos y sus campos
                SELECT
                    JSON_ARRAYAGG(
                        JSON_OBJECT(
                            "id", p.id,
                            "name", p.name,
                            "category", p.category,
                            "microsite_type", p.microsite_type,
                            "currency_type", p.currency_type,
                            "document_type", p.document_type,
                            "document", p.document,
                            "is_active", p.is_active,
                            "total_paid", p.total_paid,
                            "microsite_id", p.microsite_id,
                            "user_id", p.user_id,
                            "request_id", p.request_id,
                            "created_at", p.created_at,
                            "updated_at", p.updated_at,
                            "fields", (
                                SELECT JSON_ARRAYAGG(
                                    JSON_OBJECT(
                                        "id", pf.id,
                                        "name", pf.name,
                                        "description", pf.description,
                                        "url_img", pf.url_img,
                                        "value", pf.value,
                                        "type", pf.type,
                                        "created_at", pf.created_at,
                                        "updated_at", pf.updated_at
                                    )
                                )
                                FROM payment_fields pf
                                WHERE pf.payment_id = p.id
                            )
                        )
                    ) INTO result
                FROM payments p
                WHERE p.microsite_id = micrositeId;

                RETURN result;
            END;
        ');
    }
}
