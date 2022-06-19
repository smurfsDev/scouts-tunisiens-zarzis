<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'superAdmin',
        ]);
        Role::create([
            'name' => 'قيادة الفوج',
        ]);
        Role::create([
            'name' => 'قائد وحدة',
        ]);
        Role::create([
            'name' => 'ملازم قائد وحدة',
        ]);
        Role::create([
            'name' => 'معين قائد وحدة',
        ]);

        Role::create([
            'name' => 'فرد',
        ]);

        // Role::factory(4)->create();
    }
}
