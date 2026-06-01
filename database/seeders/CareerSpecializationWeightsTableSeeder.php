<?php

namespace Database\Seeders;

class CareerSpecializationWeightsTableSeeder extends CsvSeeder
{
    public function run(): void
    {
        $this->importCsv(
            'data/career_specialization_weights.csv',
            'career_specialization_weights',
            [
                'career_id (FK)' => 'career_id',
                'specialization_id (FK)' => 'specialization_id',
                'frequency' => 'frequency',
                'weight' => 'weight',
            ]
        );
    }
}
