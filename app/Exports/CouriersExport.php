<?php
namespace App\Exports;

use App\Models\Courier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CouriersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $year; // Année à filtrer

    public function __construct($year = null)
    {
        $this->year = $year;
    }

    public function collection()
    {
        $query = Courier::with('couriersType');

        // Appliquer le filtre de l'année si spécifié
        if ($this->year) {
            $query->whereYear('created_at', $this->year);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
        'N°',
        'Destinataire',
        'Date',
        'Objet',
        'Agent',
        'Copie à',
        'Nature',
        'Classement'
            
        ];
    }

    public function map($courier): array
    {
        return [
            $courier->id,
            $courier->couriersRecipient->label ?? 'Non défini',
            $courier->created_at->format('d/m/Y'),
            $courier->object ?? 'Non défini',
            $courier->handlingUser->first_name . ' ' . $courier->handlingUser->last_name ?? 'Non défini',
            $courier->copiedUsers->map(function($user) {
                return $user->first_name . ' ' . $user->last_name;
            })->join(', ') ?? 'Aucun',
            $courier->couriersType->name ?? 'Non défini',
            $courier->document_path ?? 'Non défini',
        ];
    }
    
}
