<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class UsersExport implements WithMapping,WithHeadings,FromQuery,WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    function __construct($from_date,$to_date) {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }


    public function query()
    {
        return User::query()
        ->whereBetween('created_at',[ $this->from_date,$this->to_date]);
    }
    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->created_at
        ];
    }
    public function headings(): array
    {
        return [
            '#',
            'Prenom et Nom',
            'Email',
            'Crée le'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(1)->getFont()->setBold(true);
    }

   
}
