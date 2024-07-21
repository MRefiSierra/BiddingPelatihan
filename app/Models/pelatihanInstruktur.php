<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class pelatihanInstruktur extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pelatihan_instruktur';
    
    protected $fillable = [
        'id_pelatihan',
        'id_instruktur',
        'tanggal_bid',
        'created_at',
        'updated_at',
    ];

    public function relasiDenganPelatihans(){
        return $this->belongsTo(Pelatihans::class, 'id_pelatihan');
    }

    public function user(){
        return $this->belongsTo(User::class, 'id_instruktur');
    }
}
