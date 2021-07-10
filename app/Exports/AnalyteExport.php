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
            ->with('workArea')
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
                $analyte->hcaLaboratory->id,
                $analyte->infinityLabdateTest->id,
                $analyte->available->id,
                $analyte->medicalOrder->id,
                $analyte->loinc->id,
                $analyte->timeProcess->id,
                $analyte->timeReception->id,
                $analyte->workArea->id,
                $analyte->fonasaTest->id,
                $analyte->quantitySampleAdul->id,
                $analyte->quantitySamplePediatric->id,
                $analyte->state->id,
                $analyte->createdUser->id,
                $analyte->updatedUser->id,
                $analyte->analyteSampleContainer->mainAnalyte->id,
                $analyte->analyteSampleContainer->container->id,
            ];

    }

    public function headings(): array
    {

        return [
            [
                'RUN',
                'Nombre',
                'Sexo',
                'Edad',
                'Tipo muestra',
                'Resultado',
                'Fecha de toma de muestra',
                'Fecha de recepción de la muestra',
                'Fecha de resultado',
                'Hospital o establecimiento de origen (lugar donde se toma la muestra)',
                'Región de establecimiento de origen',
                'Laboratorio de referencia (lugar donde se procesa la muestra)',
                'Región de laboratorio donde se procesa la muestra',
                'Teléfono de contacto de paciente',
                'Correo de contacto de paciente',
                'Dirección de contacto de paciente'
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
