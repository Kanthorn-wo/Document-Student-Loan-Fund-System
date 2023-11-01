<?php

namespace Database\Seeders;

use App\Models\Admins;
use App\Models\Admin\DatePicker;
use App\Models\Admin\FileDocument;
use App\Models\Admin\Prefix;
use App\Models\Staffs;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        DatePicker::create([
            'start_date' => '2023-04-24',
            'end_date' => '2025-04-30',
            'is_active' => 1,
        ]);
        User::create([
            'student_id' => '62172310127-0',
            'personal_id' => '1309901171739',
            'prefix_name' => 'นาย',
            'first_name' => 'กันต์ธร',
            'last_name' => 'วงษ์โสมะ',
            'email' => 'user@email.com',
            'faculty' => 'วิศวกรรมศาสตร์และเทคโนโลยี',
            'branch' => 'วิศวกรรมคอมพิวเตอร์',
            'password' => Hash::make(123456789),

        ]);
        User::create([
            'student_id' => '62172310469-1',
            'personal_id' => '2364452123654',
            'prefix_name' => 'นาย',
            'first_name' => 'นักศึกษา',
            'last_name' => 'ทดสอบ',
            'email' => 'user1@email.com',
            'faculty' => 'วิศวกรรมศาสตร์และเทคโนโลยี',
            'branch' => 'วิศวกรรมไฟฟ้า',
            'password' => Hash::make(123456789),

        ]);
        User::create([
            'student_id' => '65172310469-1',
            'personal_id' => '2123452123654',
            'prefix_name' => 'นาง',
            'first_name' => 'ทดสอบ',
            'last_name' => 'คำนำหน้า',
            'email' => 'user2@email.com',
            'faculty' => 'วิศวกรรมศาสตร์และเทคโนโลยี',
            'branch' => 'วิศวกรรมไฟฟ้า',
            'password' => Hash::make(123456789),

        ]);

        for ($i = 3; $i < 100; $i++) {
            User::create([
                'student_id' => '62' . $faker->numerify('#########') . '-' . $faker->numerify('#'),
                'personal_id' => $faker->numerify('#############'),
                'prefix_name' => $faker->randomElement(['นาย', 'นาง', 'นางสาว']),
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => 'user' . $i . "@email.com",
                'faculty' => $faker->randomElement(['วิศวกรรมศาสตร์และเทคโนโลยี', 'บริหารธุรกิจ', 'สถาบันสหสรรพศาสตร์', 'ระบบรางและการขนส่ง', 'วิทยาศาสตร์และศิลปศาสตร์', 'สถาปัตยกรรมศาสตร์และศิลปกรรมสร้างสรรค์']),
                'branch' => 'วิศวกรรมคอมพิวเตอร์',
                'password' => Hash::make(123456789),

            ]);
        }

        Admins::create([
            'first_name' => 'ผู้ดูเเลระบบ',
            'last_name' => 'ทดสอบ',
            'email' => 'admin@email.com',
            'password' => Hash::make(123456789),

        ]);
        Admins::create([
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),
            'email' => 'admin2@email.com',
            'password' => Hash::make(123456789),

        ]);
        Admins::create([
            'first_name' => $faker->firstName(),
            'last_name' => $faker->firstName(),
            'email' => 'admin1@email.com',
            'password' => Hash::make(123456789),

        ]);

        Staffs::create([
            'prefix_name' => 'นาย',
            'first_name' => 'เจ้าหน้าที่',
            'last_name' => 'ทดสอบ',
            'rank' => 'เจ้าหน้าที่ทดสอบระบบ1',
            'email' => 'staff@email.com',
            'password' => Hash::make(123456789),

        ]);

        Staffs::create([
            'prefix_name' => 'นาย',
            'first_name' => 'staff',
            'last_name' => 'test',
            'rank' => 'เจ้าหน้าที่ทดสอบระบบ2',
            'email' => 'staff1@email.com',
            'password' => Hash::make(123456789),

        ]);

        Prefix::create([
            'prefix_name' => 'นาย',
        ]);
        Prefix::create([
            'prefix_name' => 'นาง',
        ]);
        Prefix::create([
            'prefix_name' => 'นางสาว',
        ]);

        FileDocument::create([
            'admin_id' => '1',
            'subject' => 'test',
            'note' => 'test',
            'attachment' => '["test1","test2"]',
            'piece' => '["1","2"]',
            'status' => '1',
        ]);

        FileDocument::create([
            'admin_id' => '1',
            'subject' => 'xxxxxx',
            'note' => 'xxxxxx',
            'attachment' => '["xxxxx1","xxxxx2"]',
            'piece' => '["5","10"]',
            'status' => '1',
        ]);

    }
}
