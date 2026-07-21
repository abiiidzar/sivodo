<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RankingExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $rankingData;

    public function __construct($rankingData)
    {
        $this->rankingData = $rankingData;
    }

    public function collection()
    {
        $data = [];
        foreach ($this->rankingData as $index => $item) {
            $data[] = [
                'Rank' => $index + 1,
                'Nama Dosen' => $item->nama,
                'Program Studi' => $item->program_studi,
                'Total Voting' => $item->total_voting,
                'Rata-rata' => number_format($item->rata_rata, 2),
                'Kategori' => $item->kategori,
            ];
        }
        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Rank',
            'Nama Dosen',
            'Program Studi',
            'Total Voting',
            'Rata-rata',
            'Kategori'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
