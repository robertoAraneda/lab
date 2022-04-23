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

class SampleExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithEvents
{

    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $analytes = Analyte::orderBy('id')
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
                            ->where('state_id', 1)
                            ->get();


        return collect($analytes->map(function($analyte){

            $appendSampleCondition = '';

            foreach ($analyte->sampleConditions as $key => $value) {
                $appendSampleCondition .= ($key + 1).". ".$value->description.". ".PHP_EOL;
            }

            $analyte['sampleConditionPatient'] = $appendSampleCondition;

           return $analyte;
        }));
    }

    /**
     * @var Analyte $analyte
     */
    public function map($analyte): array
    {

        try {
            return [
                $analyte->id,
                $analyte->loinc->loinc_num,
                $analyte->fonasaTest == null ? '': $analyte->fonasaTest->code,
                $analyte->description,
                $analyte->available->description,
                $analyte->timeProcess->description,
                $analyte->timeReception->description,
                $analyte->workArea->description,
                $analyte->workArea->section->description,
                $analyte->analyteSampleContainer->sampleCollectionMethod->sample->description,
                $analyte->analyteSampleContainer->sampleCollectionMethod->collectionMethod->description,
                $analyte->analyteSampleContainer->container->description,
                $analyte->quantitySamplePediatric->description,
                $analyte->quantitySampleAdult->description,
                $analyte->analyteTimeResponseDetail->timeResponseAmb->description,
                $analyte->analyteTimeResponseDetail->timeResponseHosp->description,
                $analyte->analyteTimeResponseDetail->timeResponseUrg->description,
                $analyte->analyteTimeResponseDetail->timeResponseExt->description,
                $analyte['sampleConditionPatient'],
                $analyte->state->description,

            ];
        }catch (\Exception $e){
            return [
                'error' => $e->getMessage(),
                'analyte' => $analyte
            ];
        }

    }

    public function headings(): array
    {

        return [
            [
                'Número',
                'Código LOINC',
                'Código FONASA',
                'Nombre exámen',
                'Disponibilidad',
                'Tiempo de proceso',
                'Tiempo de recepción',
                'Area de trabajo',
                'Sección',
                'Tipo muestra',
                'Obtención',
                'Contenedor',
                'Volumen muestra pediatrica',
                'Volumen muestra adulto',
                'Tiempo respuesta ambulatorio',
                'Tiempo respuesta hospitalizado',
                'Tiempo respuesta urgencia',
                'Tiempo respuesta externo',
                'Condiciones del paciente',
                'Estado'
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'S' => 20,          
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

                $cellRange = 'A1:X1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle($cellRange)
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
            }
        ];
    }
}
