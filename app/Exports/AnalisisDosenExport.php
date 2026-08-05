<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AnalisisDosenExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $rows = [];

        // Header Dosen
        $rows[] = ['ANALISIS KINERJA DOSEN'];
        $rows[] = ['Nama Dosen', $this->data['dosen']->nama];
        $rows[] = ['NIDN', $this->data['dosen']->nidn];
        $rows[] = ['Program Studi', $this->data['dosen']->program_studi];
        $rows[] = ['Total Voting', $this->data['totalVoting']];
        $rows[] = ['Rata-rata Keseluruhan', number_format($this->data['rataRataKeseluruhan'], 2)];
        $rows[] = [];

        // Rata-rata per Pertanyaan
        $rows[] = ['RATA-RATA PER ASPEK PENILAIAN'];
        $rows[] = ['No', 'Kategori', 'Pertanyaan', 'Rata-rata', 'Jumlah Voting'];
        $no = 1;
        foreach ($this->data['pertanyaanList'] as $pertanyaan) {
            $rata = $this->data['rataPerPertanyaan'][$pertanyaan->id]['rata_rata'] ?? 0;
            $jumlah = $this->data['rataPerPertanyaan'][$pertanyaan->id]['jumlah'] ?? 0;
            $rows[] = [
                $no++,
                $pertanyaan->kategori,
                $pertanyaan->pertanyaan,
                number_format($rata, 2),
                $jumlah
            ];
        }
        $rows[] = [];

        // Rekap Mahasiswa
        $rows[] = ['REKAP PENILAIAN MAHASISWA'];
        $rows[] = ['No', 'Nama Mahasiswa', 'NIM', 'Total Skor', 'Rata-rata', 'Kritik', 'Saran', 'Tanggal'];
        $no = 1;
        foreach ($this->data['rekapMahasiswa'] as $item) {
            $rows[] = [
                $no++,
                $item['nama'],
                $item['nim'],
                $item['total_skor'],
                number_format($item['rata_rata'], 2),
                $item['kritik'] ?? '-',
                $item['saran'] ?? '-',
                $item['tanggal'],
            ];
        }

        return $rows;
    }

    public function headings(): array
    {
        return [];
    }

    public function styles(Worksheet $sheet)
    {
        // Merge title
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        // Bold untuk label
        $sheet->getStyle('A2:A6')->getFont()->setBold(true);

        // Style header tabel
        $sheet->getStyle('A8:H8')->getFont()->setBold(true);
        $sheet->getStyle('A8:H8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A8:H8')->getFill()->getStartColor()->setRGB('E5E7EB');

        $sheet->getStyle('A15:H15')->getFont()->setBold(true);
        $sheet->getStyle('A15:H15')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A15:H15')->getFill()->getStartColor()->setRGB('E5E7EB');

        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
            8 => ['font' => ['bold' => true]],
            15 => ['font' => ['bold' => true]],
        ];
    }
}
