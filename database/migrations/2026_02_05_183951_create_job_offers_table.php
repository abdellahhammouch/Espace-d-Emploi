<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();

            // recruteur qui a créé l'offre
            $table->foreignId('recruiter_id')->constrained('users')->cascadeOnDelete();

            $table->foreignId('contract_type_id')->constrained('contract_types');

            $table->string('title');
            $table->string('place'); // ex: Casablanca / Remote
            $table->date('start_date')->nullable();

            $table->text('description');

            // image obligatoire (tu l'as dans le CDC)
            $table->string('image_path');

            // clôture
            $table->boolean('is_closed')->default(false);
            $table->timestamp('closed_at')->nullable();

            $table->timestamps();

            $table->index(['recruiter_id', 'contract_type_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_offers');
    }
};
