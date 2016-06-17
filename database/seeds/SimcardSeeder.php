<?php

use Illuminate\Database\Seeder;

class SimcardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Simcard::class, 50)->create();
    }
}
