<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all();

        // Create 5 skills for each employee
        foreach ($employees as $employee) {
            Skill::factory()->count(5)->create([
                'employee_id' => $employee->id,
            ]);
        }
    }
}
