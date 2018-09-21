<?php

use Illuminate\Database\Seeder;
use App\DaftarSiswa;

class Siswa extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $isi1 = DaftarSiswa::create(['Nama_Siswa'=>'Robi', 'Jurusan'=>'Rekayasa Perangkat Lunak','Kelas'=>'XII']);
    }
}
