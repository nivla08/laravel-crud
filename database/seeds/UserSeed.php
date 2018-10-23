<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeed extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $user = User::create([
            'username'   => 'John Doe',
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'email'      => 'admin@admin.com',
            'active'  => true,
            'password'   => bcrypt('admin123')
        ]);
    }
}
