<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_profile_id')
                ->constrained('employee_profiles')
                ->cascadeOnDelete();

            $table->string('degree');                 // diplôme
            $table->string('school');                 // école
            $table->string('field')->nullable();      // filière (optionnel)

            $table->unsignedSmallInteger('start_year')->nullable();
            $table->unsignedSmallInteger('end_year')->nullable();

            $table->timestamps();

            $table->index('employee_profile_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};
