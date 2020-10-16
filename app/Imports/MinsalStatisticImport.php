<?php

namespace App\Imports;

use App\ModelManagement\MinsalStatistic;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class MinsalStatisticImport implements ToModel, WithChunkReading
{

    use Importable;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new MinsalStatistic([
            'id_testing_request' => $row[1],
            'sample' => $row[6],
            'result' => $row[7],
            'status' => $row[8],
            'professional_validator' => $row[9],
            'rejection_reason' => $row[16],
            'sending_institution' => $row[17],
            'processing_laboratory' => $row[18],
            'requesting_doctor' => $row[19],
            'patient_rut' => $row[2],
            'patient_name' => $row[3],
            'patient_gender' => $row[4],
            'patient_age' => $row[5],
            'patient_phone' => $row[20],
            'patient_email' => $row[21],
            'patient_comuna' => $row[22],
            'patient_address' => $row[23],
            'institution_region' => $row[24],
            'clasification' => $row[25],
            'sampled_at' => $row[10],
            'received_at' => $row[11],
            'validated_at' => $row[13],
            'notified_at' => $row[14],
            'rejected_at' => $row[15],
            'distributed_at' => $row[12]
        ]);
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 250;
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 250;
    }
}
