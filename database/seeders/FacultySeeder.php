<?php

namespace Database\Seeders;

use App\Models\Admin\Faculty;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Faculty::create([
            'faculty_code' => '1500',
            'faculty_name' => 'บริหารธุรกิจ',
        ]);
        Faculty::create([
            'faculty_code' => '1700',
            'faculty_name' => 'วิศวกรรมศาสตร์และเทคโนโลยี',
        ]);
        Faculty::create([
            'faculty_code' => '1900',
            'faculty_name' => 'สถาบันสหสรรพศาสตร์',
        ]);
        Faculty::create([
            'faculty_code' => '1030',
            'faculty_name' => 'ระบบรางและการขนส่ง',
        ]);
        Faculty::create([
            'faculty_code' => '1600',
            'faculty_name' => 'วิทยาศาสตร์และศิลปศาสตร์',
        ]);
        Faculty::create([
            'faculty_code' => '1800',
            'faculty_name' => 'สถาปัตยกรรมศาสตร์และศิลปกรรมสร้างสรรค์',
        ]);

    }
}
