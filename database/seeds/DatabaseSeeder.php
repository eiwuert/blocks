<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(ActorSeeder::class);
        //$this->call(EquipoTableSeeder::class);
        //$this->call(SimcardSeeder::class);
        //$this->call(ComisionSeeder::class);
        Model::reguard();
    }
}
