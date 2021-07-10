<?php

namespace App\Exports;

use App\Analyte;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class AnalyteExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithEvents
{

    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Analyte::orderBy('id')
            ->with('hcaLaboratory')
            ->with('infinityLabdateTest')
            ->with('available')
            ->with('medicalOrder')
            ->with('loinc')
            ->with('timeProcess')
            ->with('timeReception')
            ->with('workArea.section')
            ->with('fonasaTest')
            ->with('sampleConditions')
            ->with('quantitySamplePediatric')
            ->with('quantitySampleAdult')
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->with('analyteSampleContainer.mainAnalyte', 'analyteSampleContainer.container', 'analyteSampleContainer.sampleCollectionMethod.sample', 'analyteSampleContainer.sampleCollectionMethod.collectionMethod')
            ->with('analyteTimeResponseDetail.timeResponseUrg', 'analyteTimeResponseDetail.timeResponseHosp', 'analyteTimeResponseDetail.timeResponseExt', 'analyteTimeResponseDetail.timeResponseAmb')
            ->get();
    }

    /**
     * @var Analyte $analyte
     */
    public function map($analyte): array
    {
            return [
                $analyte->hcaLaboratory->internal_code,
                $analyte->infinityLabdateTest->code,
                $analyte->infinityLabdateTest->description,
                $analyte->available->description,
                $analyte->medicalOrder->description,
                $analyte->loinc->loinc_num,
                $analyte->loinc->long_common_name,
                $analyte->timeProcess->description,
                $analyte->timeReception->description,
                $analyte->workArea->description,
                $analyte->workArea->section->description,
                $analyte->fonasaTest->code,
                $analyte->fonasaTest->description,
                $analyte->state->description,
                $analyte->createdUser->name,
                $analyte->updatedUser->name,
                $analyte->quantitySamplePediatric->description,
                $analyte->quantitySampleAdult->description,
                $analyte->analyteSampleContainer,

            ];

    }

    public function headings(): array
    {

        return [
            [
                'Código HCA',
                'Labdate código',
                'Labdate nombre',
                'Disponibilidad',
                'Tipo solicitud',
                'Código LOINC',
                'Nombre LOINC',
                'Tiempo de proceso',
                'Tiempo de recepción',
                'Area de trabajo',
                'Sección',
                'Código FONASA',
                'Nombre FONASA',
                'Estado',
                'Usuario creador',
                'Usuario modificador',
                'Volumen muestra pediatrica',
                'Volumen muestra adulto',
                'Analito principal',
                'Contenedor',
                'Tipo muestra',
                'Obtención',
            ],
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $styleArray = [
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FFFFFF']
                    ],
                    'borders' => [
                        'top' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                        'bottom' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],

                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                        'rotation' => 90,
                        'startColor' => [
                            'argb' => '027087',
                        ],
                        'endColor' => [
                            'argb' => '027087',
                        ],
                    ],
                ];

                $cellRange = 'A1:P1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle($cellRange)
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
            }
        ];
    }
}
