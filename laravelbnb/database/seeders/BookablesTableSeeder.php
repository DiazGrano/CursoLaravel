<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bookable;


class BookablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bookable::factory()
            ->times(100)
            ->create();
    }
}
