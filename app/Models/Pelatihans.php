<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihans extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'prl',
        'lokasi',
        'kuota_instruktur',
        'kuota',
        'id_range_tanggal',
    ];

    public function relasiDenganRangeTanggal()
    {
        return $this->belongsTo(RangeTanggal::class, 'id_range_tanggal');
    }

    public function relasiDenganInstruktur()
    {
        return $this->hasMany(pelatihanInstruktur::class, 'id_instruktur');
    }
}
