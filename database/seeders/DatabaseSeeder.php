<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Localizacion;
use App\Models\Cliente;
use Database\Factories\LocalizacionFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Cliente::factory(20)
        ->has(Localizacion::factory(random_int(1,5))->hasContrato())
        ->create();
    }
}
