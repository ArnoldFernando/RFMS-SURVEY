<?php

namespace App\Exports;

use App\Models\File;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Table;
use PhpOffice\PhpSpreadsheet\Worksheet\Table\TableStyle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AllFilesExport implements FromCollection, WithHeadings, WithEvents
{
    public function collection()
    {
        return File::with('category')
            ->select(
                'file_name',
                'location',
                'description',
                'civil_case_number',
                'lot_number',
                'status',
                'category_id',
                'created_at'
            )
            ->get()
            ->map(function ($item) {
                return [
                    'file_name'         => $item->file_name,
                    'location'          => $item->location,
                    'description'       => $item->description,
                    'civil_case_number' => $item->civil_case_number,
                    'lot_number'        => $item->lot_number,
                    'status'            => $item->status,
                    'category_name'     => optional($item->category)->name,
                    'created_at'        => \Carbon\Carbon::parse($item->created_at)->format('F j Y'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'File Name',
            'Location',
            'Description',
            'Civil Case Number',
            'Lot Number',
            'Status',
            'Category Name',
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

                // Dark Blue Header Styling
                $sheet->getStyle("A1:{$highestColumn}1")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'], // White text
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '305496'], // Dark Blue
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Apply border to all cells
                $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                // Add as a styled Excel table
                $table = new Table($tableRange, 'AllFilesTable');
                $style = new TableStyle();
                $style->setShowRowStripes(true);
                $table->setStyle($style);
                $sheet->addTable($table);
            },
        ];
    }
}
