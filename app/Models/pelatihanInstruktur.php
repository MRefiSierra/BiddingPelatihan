<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pelatihanInstruktur extends Model
{
    use HasFactory;

    protected $table = 'pelatihan_instruktur';
    
    protected $fillable = [
        'id_pelatihan',
        'id_instruktur',
        'tanggal_bid',
        'created_at',
        'updated_at',
    ];

    public function relasiDenganPelatihans(){
        return $this->hasMany(Pelatihans::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'id');
    }
}
