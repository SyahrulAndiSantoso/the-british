<?php

namespace App\Exports;

use App\Models\Alamat;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KotaExport implements FromCollection, WithCustomCsvSettings, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }

    public function headings(): array
    {
        return ["City_Id", "Province_Id", "Province", "Type", "City_Name", "Postal_Code"];
    }

    public function collection()
    {
        $response = Http::withHeaders([
            'key' => 'd4d746be89057f1deddfc549552d2557',
        ])->get('https://api.rajaongkir.com/starter/city');
        $kota = $response['rajaongkir']['results'];
        return collect($kota);
    }
}
