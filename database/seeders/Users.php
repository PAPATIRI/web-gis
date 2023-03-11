<?php

namespace Database\Seeders;

use App\Models\User as Usercreate;
use Illuminate\Database\Seeder;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name'      => 'Admin Toko 1',
                'email'     => 'admin1@gmail.com',
                'password'  => bcrypt('12345678'),
            ],
            [
                'name'      => 'Admin Toko 2',
                'email'     => 'admin2@gmail.com',
                'password'  => bcrypt('12345678'),
            ],
        ];

        foreach ($data as $datas) {
            Usercreate::create($datas);
        }
    }
}
