<?php

namespace Database\Seeders;

class CareersTableSeeder extends CsvSeeder
{
    public function run(): void
    {
        $this->importCsv('data/careers.csv', 'careers');
    }
}
