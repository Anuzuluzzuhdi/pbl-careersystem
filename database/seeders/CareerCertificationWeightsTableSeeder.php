<?php

namespace Database\Seeders;

class CareerCertificationWeightsTableSeeder extends CsvSeeder
{
    public function run(): void
    {
        $this->importCsv(
            'data/career_certification_weights.csv',
            'career_certification_weights',
            [
                'career_id (FK)' => 'career_id',
                'certification_id (FK)' => 'certification_id',
                'frequency' => 'frequency',
                'weight' => 'weight',
            ]
        );
    }
}
