<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PendingReturn;

class PendingReturnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PendingReturn::create([
            'product' => 5,
            'owner_id' => 8,
            'loaner_id' => 22
        ]);
    }
}
