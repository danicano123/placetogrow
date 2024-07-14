<?php

use App\Application\Constants\DocumentTypes;
use App\Application\Constants\MicrositeTypes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('microsites', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('slug', 50)->unique();
            $table->string('logo_url')->nullable();
            $table->string('category', 50);
            $table->enum('microsite_type', MicrositeTypes::values());
            $table->string('currency_type', 10);
            $table->integer('payment_expiration_time')->nullable();
            $table->enum('document_type', DocumentTypes::values())->nullable();
            $table->string('document', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('microsites');
    }
};
