<?php

use App\Domain\Users\Applications\Constants\DocumentTypes;
use App\Domain\Microsites\Applications\Constants\MicrositeTypes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->nullable();
            $table->string('category', 20)->nullable();
            $table->enum('microsite_type', MicrositeTypes::values())->nullable();
            $table->string('currency_type', 10)->nullable();
            $table->enum('document_type', DocumentTypes::values())->nullable();
            $table->string('document', 20)->nullable();
            $table->boolean('is_active')->default(true);
            $table->decimal('total_paid', 10, 2)->nullable();
            $table->integer('request_id')->nullable();
            $table->foreignId('microsite_id')->constrained('microsites')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
