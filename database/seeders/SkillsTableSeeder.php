<?php

namespace Database\Seeders;

class SkillsTableSeeder extends CsvSeeder
{
    public function run(): void
    {
        $this->importCsv('data/skills.csv', 'skills');
    }
}
