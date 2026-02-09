<?php

namespace Database\Factories;

use App\Models\JobOffer;
use App\Models\User;
use App\Models\ContractType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

class JobOfferFactory extends Factory
{
    protected $model = JobOffer::class;

    public function definition(): array
    {
        $image = UploadedFile::fake()->image('offer.jpg', 1200, 700);
        $path = $image->store('job_offers', 'public');

        return [
            'recruiter_id' => User::query()->inRandomOrder()->value('id'),
            'contract_type_id' => ContractType::query()->inRandomOrder()->value('id'),
            'title' => fake()->jobTitle(),
            'place' => fake()->city(),
            'start_date' => fake()->dateTimeBetween('+10 days', '+6 months')->format('Y-m-d'),
            'description' => fake()->paragraphs(3, true),
            'image_path' => $path,
            'is_closed' => false,
            'closed_at' => null,
        ];
    }
}
