<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
class UserExport implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::select('id', 'name', 'lastname', 'slug', 'role', 'status', 'phone', 'mobile', 'address', 'location', 'email')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            trans('Name'),
            trans('Lastname'),
            trans('Url'),
            trans('Role'),
            trans('Status'),
            trans('Phone'),
            trans('Mobile'),
            trans('Address'),
            trans('Location'),
            trans('Email'),
        ];
    }

    public function title(): string
    {
        return 'Usuarios';
    }
}
