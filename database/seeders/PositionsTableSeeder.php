<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionsTableSeeder extends Seeder
{
    private $professions = [
        'Web Developer',
        'Interface Designer',
        'Programmer',
        'Software Engineer',
        'Data Analyst',
        'System Administrator',
        'Software Tester',
        'Automation Test Engineer',
        'Frontend Developer',
        'Backend Developer',
        'Fullstack Developer',
        'Mobile Developer',
        'Game Designer',
        'Game Developer',
        'Software Architect',
        'DevOps Engineer',
        'Systems Analyst',
        'UX Designer',
        'UI Designer',
        'IT Consultant',
        'Technical Support Engineer',
        'Network Administrator',
        'Information Security Specialist',
        'Database Administrator',
        'Machine Learning Specialist',
        'Business Analyst',
        'System Architect',
        'Natural Language Processing Specialist',
        'Data Scientist',
        'Product Manager',
        'Systems Engineer',
        'Database Administrator',
        'Technical Writer',
        'Project Management Specialist',
        'Business Process Analyst',
        'Consultant Engineer',
        'Artificial Intelligence Developer',
        'Cybersecurity Specialist',
        'Software Quality Analyst',
        'Technical Director',
        'Process Automation Specialist',
        'Security Testing Specialist',
        'Content Manager',
        'Big Data Analyst',
        'Information Technology Specialist',
        'Web Designer',
        'Automation Programmer Engineer',
        'Data Analytics Specialist',
        'Software Quality Assurance Engineer',
        'Implementation Specialist',
        'Digital Analytics Specialist',
        'Mobile App Analyst',
        'Information Security Consultant',
        'Business Analysis Specialist',
        'Machine Learning Analyst',
        'IT Project Technical Consultant',
        'Data Processing Specialist',
        'Product Manager',
        'Database Architect',
        'Process Automation Engineer',
        'Software Testing Specialist',
        'Information Systems Specialist',
        'Business Development Specialist',
        'SEO Analyst',
        'Technical Analyst',
        'Network Administrator',
        'Information Systems Integrator',
        'Software Support Specialist',
        'E-commerce Analyst'
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->professions as $value){

            $arr = [
                'name' => $value
            ];
            $exist  = DB::table('positions')->select('id')->where(['name' => $value])->exists();
            if (!$exist) {
                DB::table('positions')->insert($arr);
            }
        }
    }
}
