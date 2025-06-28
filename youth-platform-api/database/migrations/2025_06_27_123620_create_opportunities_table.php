<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('opportunities', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description')->nullable();
        $table->string('url');
        $table->string('qualification')->nullable();
        $table->string('region')->nullable();
        $table->date('deadline')->nullable();
        $table->enum('type', ['Scholarship', 'Job', 'Training']);
        $table->timestamps();
    });
}

};
