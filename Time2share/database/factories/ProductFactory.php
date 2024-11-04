<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'name' => fake()->name(),
        'description' => fake()->word(),
        'category' => fake()->word(),
        'deadline' => fake()->date('y-m-d'),
        'owner_id' => User::pluck('id')->random(),
        'loaner_id' => User::pluck('id')->random(),
        'loaned_out' => fake()->boolean(),
        ];
    }
}
