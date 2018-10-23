<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call(UserSeed::class);
        $this->call(RolesAndPermissionsSeeder::class);
        // factory(App\Models\Users\User::class, 50)->create();
    }
}
