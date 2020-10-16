<?php

namespace App\Exports;


use App\ModelManagement\MinsalDetail as MinsalDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class MinsalExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithEvents
{

  use Exportable;

  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return MinsalDetail::all();
  }

  /**
   * @var MinsalDetail $minsalDetail
   */
  public function map($minsalDetail): array
  {

    if ($minsalDetail->processing_laboratory_name == 'LABORATORIO HHHA') {
      return [
        $minsalDetail->patient_rut,
        $minsalDetail->patient_name,
        $minsalDetail->patient_gender,
        $minsalDetail->patient_age,
        $minsalDetail->sample,
        $minsalDetail->result,
        $minsalDetail->sampled_at,
        $minsalDetail->received_at,
        $minsalDetail->validated_at,
        $minsalDetail->requesting_institution_name,
        $minsalDetail->requesting_institution_region,
        $minsalDetail->processing_laboratory_name,
        $minsalDetail->processing_laboratory_region,
        $minsalDetail->patient_phone,
        $minsalDetail->patient_email,
        $minsalDetail->patient_address,
      ];
    }else{
      return [];
    }
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
      BeforeExport::class  => function(BeforeExport $event) {
        $event->writer->getDelegate()->getSecurity()->setLockWindows(true);
        $event->writer->getDelegate()->getSecurity()->setLockStructure(true);
        $event->writer->getDelegate()->getSecurity()->setWorkbookPassword("Minsal2020");
      },
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
