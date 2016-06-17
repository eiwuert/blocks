<?php

use Illuminate\Database\Seeder;

class ActorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actors = factory(App\Actor::class, 5)->create();
        $actors = factory(App\Actor::class, 1)->create([
        'cedula' => '1015439593',
       ]);
    }
}
