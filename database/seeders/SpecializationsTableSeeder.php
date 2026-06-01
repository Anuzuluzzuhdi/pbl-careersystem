<?php

namespace Database\Seeders;

class SpecializationsTableSeeder extends CsvSeeder
{
    public function run(): void
    {
        $this->importCsv('data/specializations.csv', 'specializations');
    }
}
