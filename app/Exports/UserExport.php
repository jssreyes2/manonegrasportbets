<?php

namespace App\Exports;

use App\Repositories\Settings\UserRepository;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class UserExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    
    use Exportable;
    
    public function __construct($filter = [])
    {
        $this->filter = $filter;
    }
    
    public function query()
    {
        return UserRepository::getUserProfile($this->filter);
    }
    
    public function headings(): array
    {
        return [
            'Nombres',
            'Apellidos',
            'Correo electrónico',
            'Teléfono',
            'Profesión',
            'Status',
            'Creación'
        ];
    }
    
    public function map($row): array
    {
        $status = $row->is_active == 1 ? 'Active' : 'Inactive';
        return [
            capitalize_first($row->first_name),
            capitalize_first($row->last_name),
            $row->email,
            $row->phone,
            $row->profession,
            $status,
            date_formt($row->created_at),
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        // Obtener el rango de datos (asumiendo que tienes datos desde fila 1 hasta la última)
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();
        
        // Aplicar negritas a los encabezados (fila 1)
        $sheet->getStyle('A1:' . $lastColumn . '1')->getFont()->setBold(true);
        
        // Aplicar bordes a toda la tabla
        $sheet->getStyle('A1:' . $lastColumn . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);
        
        // Opcional: Color de fondo para los encabezados
        $sheet->getStyle('A1:' . $lastColumn . '1')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFE0E0E0'], // Gris claro
            ]
        ]);
        
        return [];
    }
}