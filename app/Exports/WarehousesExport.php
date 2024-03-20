<?php

namespace App\Exports;

use App\Models\Warehouse;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class WarehousesExport implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Warehouse::select('id', 'name','slug','location','address','status','branch_manager','phone','mobile','cashiers','details')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            trans('Name'),
            trans('Url'),
            trans('Location'),
            trans('Address'),
            trans('Status'),
            trans('Branch Manager'),
            trans('Phone'),
            trans('Mobile'),
            trans('Cashiers'),
            trans('Details'),
        ];
    }

    public function title(): string
    {
        return 'Sucursales';
    }

}
