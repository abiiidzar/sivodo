<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanMatakuliahExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $matakuliahs;

    public function __construct($matakuliahs)
    {
        $this->matakuliahs = $matakuliahs;
    }

    public function collection()
    {
        $data = [];
        foreach ($this->matakuliahs as $index => $mk) {
            $data[] = [
                'No' => $index + 1,
                'Kode' => $mk->kode,
                'Mata Kuliah' => $mk->nama,
                'Dosen Pengampu' => $mk->dosen->nama ?? '-',
                'Semester' => $mk->semester,
                'Kelas' => $mk->kelas ?? '-',
                'Total Voting' => $mk->total_voting ?? 0,
                'Rata-rata' => number_format($mk->rata_rata ?? 0, 2),
            ];
        }
        return collect($data);
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode',
            'Mata Kuliah',
            'Dosen Pengampu',
            'Semester',
            'Kelas',
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
