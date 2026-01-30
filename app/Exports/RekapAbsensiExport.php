<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithCharts, WithTitle};
use PhpOffice\PhpSpreadsheet\Chart\{Chart, DataSeries, DataSeriesValues, Legend, PlotArea, Title};

class RekapAbsensiExport implements FromCollection, WithHeadings, WithCharts, WithTitle
{
    public function __construct(public $rekap) {}

    public function collection()
    {
        return $this->rekap->map(function ($r) {
            return [$r->name, $r->NISN, $r->hadir, $r->izin, $r->sakit, $r->alpa, $r->total];
        });
    }

    public function headings(): array
    {
        return ['Nama', 'NISN', 'Hadir', 'Izin', 'Sakit', 'Alpa', 'Total'];
    }

    public function charts()
    {
        $labels = [
            new DataSeriesValues('String', 'Worksheet!$C$1', null, 1),
            new DataSeriesValues('String', 'Worksheet!$D$1', null, 1),
            new DataSeriesValues('String', 'Worksheet!$E$1', null, 1),
            new DataSeriesValues('String', 'Worksheet!$F$1', null, 1),
        ];

        $values = [
            new DataSeriesValues('Number', 'Worksheet!$C$2:$C$100'),
            new DataSeriesValues('Number', 'Worksheet!$D$2:$D$100'),
            new DataSeriesValues('Number', 'Worksheet!$E$2:$E$100'),
            new DataSeriesValues('Number', 'Worksheet!$F$2:$F$100'),
        ];

        $series = new DataSeries(
            DataSeries::TYPE_BARCHART,
            DataSeries::GROUPING_CLUSTERED,
            range(0, count($values) - 1),
            $labels,
            [],
            $values,
        );

        $plotArea = new PlotArea(null, [$series]);

        return new Chart('rekap_chart', new Title('Grafik Rekap Absensi'), new Legend(), $plotArea);
    }

    public function title(): string
    {
        return 'Rekap Absensi';
    }
}
