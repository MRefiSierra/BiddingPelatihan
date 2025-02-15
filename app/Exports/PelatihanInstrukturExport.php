<?php

namespace App\Exports;

use App\Models\PelatihanInstruktur;
use App\Models\Pelatihans;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PelatihanInstrukturExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $months;
    protected $year;

    public function __construct($months, $year)
    {
        $this->months = $months;
        $this->year = $year;
    }


    public function collection()
    {
        $start = Carbon::create($this->year . '-' . $this->months[0] . '-01')->startOfMonth()->toDateString();
        $end = Carbon::create($this->year . '-' . $this->months[count($this->months) - 1] . '-01')->endOfMonth()->toDateString();

        // Mengubah query untuk mencakup semua bulan yang dipilih
        return Pelatihans::with(['relasiDenganRangeTanggal', 'relasiDenganInstruktur' => function ($query) {
            $query->whereNull('deleted_at')->with('user');
        }])
            ->whereHas('relasiDenganRangeTanggal', function ($query) use ($start, $end) {
                $query->whereBetween('tanggal_mulai', [$start, $end]);
            })
            ->get();
    }


    public function headings(): array
    {
        return [
            'Nama Pelatihan',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Lokasi',
            'Kuota',
            'Kuota Instruktur',
            'Instruktur 1',
            'Instruktur 2',
        ];
    }

    public function map($pelatihan): array
    {
        $instruktur1 = $pelatihan->relasiDenganInstruktur->sortBy('id')->first();
        $instruktur2 = $pelatihan->relasiDenganInstruktur->sortBy('id')->skip(1)->first();
    
        return [
            $pelatihan->nama,
            optional($pelatihan->relasiDenganRangeTanggal)->tanggal_mulai ? Carbon::parse($pelatihan->relasiDenganRangeTanggal->tanggal_mulai)->format('d F Y') : '',
            optional($pelatihan->relasiDenganRangeTanggal)->tanggal_selesai ? Carbon::parse($pelatihan->relasiDenganRangeTanggal->tanggal_selesai)->format('d F Y') : '',
            $pelatihan->lokasi,
            $pelatihan->kuota,
            $pelatihan->kuota_instruktur,
            optional($instruktur1)->user->name ?? '',
            optional($instruktur2)->user->name ?? '',
        ];
    }
    
}
