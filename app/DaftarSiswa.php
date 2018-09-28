<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DaftarSiswa extends Model
{
    protected $table = 'daftar_siswas';
    protected $fillable = ['Nama_Siswa','Jenis_Kelamin','Tanggal_Lahir','Jurusan','Kelas','Alamat','Hobi', 'Foto'];
    public $timestamp = true;
}
