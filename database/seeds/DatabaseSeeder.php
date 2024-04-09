<?php

use App\User;
use App\OsGroup;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@claro.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'remember_token' => '0kTKh8H1iP',
        ]);
        OsGroup::create([
            'name' => 'Administrators',
            'flag' => 17,
        ]);
        OsGroup::create([
            'name' => 'Remote Users',
            'flag' => 17,
        ]);
        OsGroup::create([
            'name' => 'Users',
            'flag' => 17,
        ]);
        OsGroup::create([
            'name' => 'bkptmx',
            'flag' => 16,
        ]);
        OsGroup::create([
            'name' => 'sapsys',
            'flag' => 16,
        ]);
        OsGroup::create([
            'name' => 'dbatmx',
            'flag' => 16,
        ]);
        OsGroup::create([
            'name' => 'admgenesys',
            'flag' => 16,
        ]);
        OsGroup::create([
            'name' => 'apptmx',
            'flag' => 16,
        ]);
        $this->call([
            PermissionTableSeeder::class,
            //PruebasTableSeeder::class,
        ]);

    }
}
