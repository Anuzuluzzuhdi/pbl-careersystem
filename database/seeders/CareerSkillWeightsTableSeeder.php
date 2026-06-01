<?php

namespace Database\Seeders;

class CareerSkillWeightsTableSeeder extends CsvSeeder
{
    public function run(): void
    {
        $this->importCsv(
            'data/career_skill_weights.csv',
            'career_skill_weights',
            [
                'career_id (FK)' => 'career_id',
                'skill_id (FK)' => 'skill_id',
                'frequency' => 'frequency',
                'weight' => 'weight',
            ]
        );
    }
}
