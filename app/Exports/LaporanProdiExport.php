<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanProdiExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $rows = [];
        foreach ($this->data as $index => $item) {
            $rows[] = [
                'No' => $index + 1,
                'Program Studi' => $item->program_studi,
                'Total Dosen' => $item->total_dosen,
                'Dosen dengan Voting' => $item->dosen_with_voting,
                'Total Voting' => $item->total_voting,
                'Rata-rata' => number_format($item->rata_rata, 2),
            ];
        }
        return collect($rows);
    }

    public function headings(): array
    {
        return [
            'No',
            'Program Studi',
            'Total Dosen',
            'Dosen dengan Voting',
            'Total Voting',
            'Rata-rata'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
