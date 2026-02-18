<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PemainFormRegistration extends Model
{
    use HasFactory;

    protected $table = 'pemain_form_registrations';

    protected $fillable = [
        'added_by',
        'status',
        'club_id',
        'keterangan',
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
        'ijazah_file_path',
        'akta_file_path',
        'kartu_kelahiran_file_path',
        'identitas_file_path',
        'surat_kerjasama_file_path'
    ];


    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function club()
    {
        return $this->belongsTo(Club::class, 'club_id');
    }
}
