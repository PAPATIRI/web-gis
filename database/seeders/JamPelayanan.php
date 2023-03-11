<?php

namespace Database\Seeders;

use App\Models\JamPelayanan as JamPelayanans;
use Illuminate\Database\Seeder;

class JamPelayanan extends Seeder
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
                'jam_buka'   => '07.00',
                'jam_tutup'   => '07.00',
            ],
            [
                'jam_buka'   => '08.00',
                'jam_tutup'   => '08.00',
            ],
            [
                'jam_buka'   => '09.00',
                'jam_tutup'   => '09.00',
            ],
            [
                'jam_buka'   => '10.00',
                'jam_tutup'   => '10.00',
            ],
            [
                'jam_buka'   => '11.00',
                'jam_tutup'   => '11.00',
            ],
            [
                'jam_buka'   => '12.00',
                'jam_tutup'   => '12.00',
            ],
            [
                'jam_buka'   => '13.00',
                'jam_tutup'   => '13.00',
            ],
            [
                'jam_buka'   => '14.00',
                'jam_tutup'   => '14.00',
            ],
            [
                'jam_buka'   => '15.00',
                'jam_tutup'   => '15.00',
            ],
            [
                'jam_buka'   => '16.00',
                'jam_tutup'   => '16.00',
            ],
            [
                'jam_buka'   => '17.00',
                'jam_tutup'   => '17.00',
            ],
            [
                'jam_buka'   => '18.00',
                'jam_tutup'   => '18.00',
            ],
            [
                'jam_buka'   => '19.00',
                'jam_tutup'   => '19.00',
            ],
            [
                'jam_buka'   => '20.00',
                'jam_tutup'   => '20.00',
            ],
            [
                'jam_buka'   => '21.00',
                'jam_tutup'   => '21.00',
            ],
            [
                'jam_buka'   => '22.00',
                'jam_tutup'   => '22.00',
            ],
            [
                'jam_buka'   => '23.00',
                'jam_tutup'   => '23.00',
            ],
            [
                'jam_buka'   => '24.00',
                'jam_tutup'   => '24.00',
            ],

        ];

        foreach ($data as $datas) {
            JamPelayanans::create($datas);
        }
    }
}
