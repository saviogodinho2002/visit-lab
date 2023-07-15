<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Routing\Route;
use Spatie\Permission\Models\Role;

class RolesSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(["name" => "admin"]);
        $professor = Role::create(["name" => "professor"]);
        $monitor = Role::create(["name" => "monitor"]);

        $users = User::all();
        $users[0]->assignRole("admin");
    }
}
