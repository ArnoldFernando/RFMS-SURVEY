<?php

namespace App\Exports;

use App\Models\Communication;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class CommunicationsByStatusExport implements FromCollection, WithHeadings, WithEvents
{
    protected $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function collection()
    {
        return Communication::where('status', $this->status)
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

                // Auto-size columns
                foreach (range('A', $highestColumn) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // Header styling (dark blue background)
                $sheet->getStyle("A1:{$highestColumn}1")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '305496'], // dark blue
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Border styling
                $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);
            },
        ];
    }
}
