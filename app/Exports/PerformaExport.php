<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PerformaExport implements FromView, ShouldAutoSize, WithEvents
{
    public $rows = 0;

    public function __construct($resultData)
    {
        $this->resultData = $resultData;
        $this->rows = count($resultData)+2;

    }

    public function view(): View
    {
        setlocale(LC_TIME, 'id_ID');
        \Carbon\Carbon::setLocale('id');
        \Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");

        return view('exports.performa',[
            'datas' => $this->resultData
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                // $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $event->sheet->getStyle('A1:K2')->applyFromArray(
                    [
                        'font' => [
                            'bold' => true
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ],
                        ]
                    ]
                );
                $event->sheet->getStyle('A2:K'.$this->rows)->applyFromArray(
                    [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ],
                        ]
                    ]
                );
            },
        ];
    }
}
