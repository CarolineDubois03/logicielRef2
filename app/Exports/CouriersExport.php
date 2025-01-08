<?php

// App/Exports/CouriersExport.php

namespace App\Exports;

use App\Models\Courier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CouriersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Vous pouvez personnaliser la requête ici
        return Courier::with('couriersType')->get();
    }

    public function headings(): array
    {
        return [
            'N°',
            'Nom',
            'Reference',
            'Categorie',
            'Created At',
        ];
    }

    public function map($courier): array
    {
        return [
            $courier->id,
            $courier->name,
            $courier->reference,
            $courier->category,
            $courier->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
