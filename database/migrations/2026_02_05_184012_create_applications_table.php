<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_offer_id')->constrained('job_offers')->cascadeOnDelete();

            // candidat (user_id)
            $table->foreignId('employee_id')->constrained('users')->cascadeOnDelete();

            $table->string('status')->default('pending'); // pending|accepted|rejected
            $table->text('note')->nullable(); // optionnel: petit message du candidat

            $table->timestamps();

            // empêcher le même candidat de postuler 2 fois à la même offre
            $table->unique(['job_offer_id', 'employee_id']);
            $table->index(['employee_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
