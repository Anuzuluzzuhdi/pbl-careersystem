<?php

namespace Database\Seeders;

class CareerEducationWeightsTableSeeder extends CsvSeeder
{
    public function run(): void
    {
        $this->importCsv(
            'data/career_education_weights.csv',
            'career_education_weights',
            [
                'career_id (FK)' => 'career_id',
                'education_id (FK)' => 'education_id',
                'frequency' => 'frequency',
                'weight' => 'weight',
            ]
        );
    }
}
