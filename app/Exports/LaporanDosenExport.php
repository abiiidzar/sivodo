<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanDosenExport implements FromCollection, WithHeadings, WithStyles
{
    protected $dosens;

    public function __construct($dosens)
    {
        $this->dosens = $dosens;
    }

    public function collection()
    {
        $data = [];
        foreach ($this->dosens as $index => $dosen) {
            $data[] = [
                'No' => $index + 1,
                'Nama Dosen' => $dosen->nama,
                'NIDN' => $dosen->nidn,
                'Program Studi' => $dosen->program_studi,
                'Status Dosen' => $dosen->status_dosen,
                'Total Voting' => $dosen->total_voting,
                'Rata-rata' => number_format($dosen->rata_rata, 2),
                'Kategori' => $dosen->kategori,
            ];
        }
        return collect($data);
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Dosen',
            'NIDN',
            'Program Studi',
            'Status Dosen',
            'Total Voting',
            'Rata-rata',
            'Kategori'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
