<?php

namespace App\Exports;

use App\Models\File;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithEvents,
    ShouldAutoSize
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Table;
use PhpOffice\PhpSpreadsheet\Worksheet\Table\TableStyle;


class FilesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents, ShouldAutoSize
{
    protected $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function collection()
    {
        return File::where('status', $this->status)->with('category')->get();
    }

    public function map($item): array
    {
        return [
            $item->file_name,
            $item->location,
            $item->description,
            $item->civil_case_number,
            $item->lot_number,
            $item->status,
            $item->category ? $item->category->name : null,
            $item->created_at ? $item->created_at->format('F j, Y') : null,
        ];
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

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Header row bold
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestColumn = $sheet->getHighestColumn();
                $highestRow = $sheet->getHighestRow();
                $tableRange = 'A1:' . $highestColumn . $highestRow;

                // Create a new Table object
                $table = new Table($tableRange, 'FilesTable');

                // Apply style
                $style = new TableStyle();
                $style->setShowRowStripes(true);
                $table->setStyle($style);

                // Add the table to the sheet
                $sheet->addTable($table);
            },
        ];
    }
}
