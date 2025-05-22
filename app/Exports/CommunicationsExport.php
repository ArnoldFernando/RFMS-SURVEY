<?php

namespace App\Exports;

use App\Models\Communication;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Table;
use PhpOffice\PhpSpreadsheet\Worksheet\Table\TableStyle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class CommunicationsExport implements FromCollection, WithHeadings, WithEvents
{
    public function collection()
    {
        return Communication::with('user') // if you want to include user info
            ->get()
            ->map(function ($item) {
                return [
                    'file_name'        => $item->file_name,
                    'tracking_number'  => $item->tracking_number,
                    'location'         => $item->location,
                    'description'      => $item->description,
                    'status'           => $item->status,
                    'created_at'       => optional($item->created_at)->format('F j Y'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'File Name',
            'Tracking Number',
            'Location',
            'Description',
            'Status',
            'Created At',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestColumn = $sheet->getHighestColumn();
                $highestRow = $sheet->getHighestRow();
                $tableRange = "A1:{$highestColumn}{$highestRow}";

                // Auto-size columns
                foreach (range('A', $highestColumn) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // Header Style - Dark Blue
                $sheet->getStyle("A1:{$highestColumn}1")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'], // white text
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '305496'], // dark blue
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Add borders to all cells
                $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                // Add table formatting with row striping
                $table = new Table($tableRange, 'CommunicationsTable');
                $table->setStyle((new TableStyle())->setShowRowStripes(true));
                $sheet->addTable($table);
            },
        ];
    }
}
