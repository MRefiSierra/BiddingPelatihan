<?php

namespace App\Exports;

use App\Models\Pelatihans;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InstrukturPelatihanExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function collection()
    {
        $tanggal = Carbon::now();
        $start = $tanggal->toDateString();
        $end = $tanggal->addMonths(6)->endOfMonth()->toDateString();

        return Pelatihans::with(['relasiDenganRangeTanggal', 'relasiDenganInstruktur' => function ($query) {
            $query->whereNull('deleted_at')->with('user');
        }])
            ->whereHas('relasiDenganRangeTanggal', function ($query) use ($start, $end) {
                $query->whereBetween('tanggal_mulai', [$start, $end]);
            })
            ->whereHas('relasiDenganInstruktur', function ($query) {
                $query->where('id_instruktur', $this->id);
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
            // 'Kuota Instruktur',
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
            // $pelatihan->kuota_instruktur,
            optional($instruktur1)->user->name ?? '',
            optional($instruktur2)->user->name ?? '',
        ];
    }
}
