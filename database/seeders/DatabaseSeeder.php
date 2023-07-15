<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Laboratory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        Laboratory::create(
          [
              "name"=>"Laboratório de Algoritmos",
              "teacher"=>"Rennan",
              "classroom"=>"37"
          ]
        );

         \App\Models\User::factory()->create([
            'name' => 'Admin',
             'email' => 'admin@email.com',
             "password"=>Hash::make("wendy123"),
             "register"=>"2022008850",

         ]);
        \App\Models\User::factory()->create([
            'name' => 'Rennan Professor',
            'email' => 'rennan@email.com',
            "password"=>Hash::make("wendy123"),
            "register"=>"2022008850",

            "laboratory_id"=>1
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Wendy Wynne',
            'email' => 'wendy@email.com',
            "password"=>Hash::make("wendy123"),
            "register"=>"2022008850",

            "laboratory_id"=>1
        ]);
        $this->call(RolesSeed::class);

    }
}
