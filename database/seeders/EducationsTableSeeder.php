<?php

namespace Database\Seeders;

class EducationsTableSeeder extends CsvSeeder
{
    public function run(): void
    {
        $this->importCsv('data/educations.csv', 'educations');
    }
}
