

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('url');
            $table->string('criteria')->nullable();
            $table->text('country_region')->nullable();
            $table->date('deadline')->nullable();
            $table->string('type');
            $table->string('funding_salary')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('opportunities');
    }
};
