<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        DB::table('users')->insert([
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'role' => 'admin',
        ]);

        DB::table('users')->insert([
            'username' => 'kasir',
            'password' => bcrypt('kasir'),
            'role' => 'kasir',
        ]);

        DB::table('users')->insert([
            'username' => 'owner',
            'password' => bcrypt('owner'),
            'role' => 'owner',
        ]);

        DB::table('kategori__produks')->insert([
            'nama_kategori_produk' => 'kemeja',
        ]);

        DB::table('users')->insert([
            'nama_user' => 'syahrul riza andi',
            'email' => 'asyahrulriza@gmail.com',
            'username' => 'asyahrulriza',
            'password' => bcrypt('12345'),
            'role' => 'pembeli',
        ]);
    }
}
