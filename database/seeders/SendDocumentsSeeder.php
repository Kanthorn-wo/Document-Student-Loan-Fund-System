<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SendDocumentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {
            DB::table('send_documents')->insert([
                [
                    'user_id' => $faker->numberBetween(1, 50),
                    'file_document_id' => 1,
                    'faculty_id' => $faker->numberBetween(1, 6),
                    'img' => 'image/services/1764051947670789.pdf',
                    'amount' => $faker->numberBetween(10000, 30000),
                    'year' => $faker->randomElement(['2566', '2565', '2564']),
                    'term' => $faker->randomElement(['1', '2', '3']),
                    'type_loan' => $faker->randomElement(['11', '21', '22', '23']),
                    'status' => $faker->randomElement(['0', '1', '2']),
                    'comment' => null,
                    'created_at' => '2023-04-24 17:26:12',
                ],
            ]);
        }

        for ($i = 0; $i < 50; $i++) {
            DB::table('send_documents')->insert([
                [
                    'user_id' => $faker->numberBetween(1, 50),
                    'file_document_id' => 2,
                    'faculty_id' => $faker->numberBetween(1, 6),
                    'img' => 'image/services/1764051947670789.pdf',
                    'amount' => $faker->numberBetween(10000, 30000),
                    'year' => $faker->randomElement(['2566', '2565', '2564']),
                    'term' => $faker->randomElement(['1', '2', '3']),
                    'type_loan' => $faker->randomElement(['11', '21', '22', '23']),
                    'status' => $faker->randomElement(['0', '1', '2']),
                    'comment' => null,
                    'created_at' => '2023-04-24 17:26:12',
                ],
            ]);
        }
    }
}
