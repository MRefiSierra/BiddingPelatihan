<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RangeTanggal extends Model
{
    use HasFactory;

    protected $table = 'range_tanggal';
    protected $fillable = [
        'tanggal_mulai',
        'tanggal_selesai'
    ];

    public function relasiDenganPelatihans(){
        return $this->hasMany(Pelatihans::class, 'id_range_tanggal');
    }
}
