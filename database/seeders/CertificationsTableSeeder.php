<?php

namespace Database\Seeders;

class CertificationsTableSeeder extends CsvSeeder
{
    public function run(): void
    {
        $this->importCsv('data/certifications.csv', 'certifications');
    }
}
