<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Database\Seeders\EventSeeder;
use Database\Seeders\WorkshopSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();


        \App\Models\User::factory(2)->create();
        $this->call(ResponsablitySeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(TroupeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MaterielSeeder::class);
        $this->call(CategorieMaterielSeeder::class);
        $this->call(DemandeMaterielSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(WorkshopSeeder::class);
    }
}
