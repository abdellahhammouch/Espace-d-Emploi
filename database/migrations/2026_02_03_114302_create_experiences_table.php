<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_profile_id')
                ->constrained('employee_profiles')
                ->cascadeOnDelete();

            $table->string('job_title');                 // poste
            $table->string('company');                   // entreprise
            $table->string('employment_type')->nullable(); // stage, CDI...

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);

            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('employee_profile_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
