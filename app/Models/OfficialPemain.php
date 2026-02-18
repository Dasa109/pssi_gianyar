<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficialPemain extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'status',

        'nama_lengkap',
        'panggilan',
        'tanggal_lahir',
        'jenis_id',
        'no_id',
        'kewarganegaraan',
        'provinsi',
        'kota',
        'tinggi_badan',
        'berat_badan',
        'alamat',
        'no_hp',
        'email',

        // ✅ FILE PATHS — MUST MATCH DB COLUMN NAMES
        'ijazah_file_path',
        'akta_file_path',
        'kartu_kelahiran_file_path',
        'identitas_file_path',
        'surat_kerjasama_file_path',
    ];
}
