<?php

namespace Database\Seeders;

use App\Models\Curriculum;
use App\Models\Lecture;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);


        Lecture::factory()->create([
            'subject' => 'Основы ООП',
            'description' => 'Описание лекции "Основы ООП"',
        ]);

        Lecture::factory()->create([
            'subject' => 'Принципы SOLID',
            'description' => 'Описание лекции "Принципы SOLID"',
        ]);

        Lecture::factory()->create([
            'subject' => 'Основы SQL',
            'description' => 'Описание лекции "Основы SQL"',
        ]);


        Student::factory()
            ->count(3)
            ->forClassroom([
                'name' => 'Класс PHP',
            ])
            ->create();

        Student::factory()
            ->count(3)
            ->forClassroom([
                'name' => 'Класс Python',
            ])
            ->create();

        Student::factory()
            ->count(3)
            ->forClassroom([
                'name' => 'Класс Java',
            ])
            ->create();


        Curriculum::factory()->create([
            'classroom_id' => 1,
            'lecture_id' => 1,
            'audition_date' => '2024-07-08',
        ]);

        Curriculum::factory()->create([
            'classroom_id' => 1,
            'lecture_id' => 2,
            'audition_date' => '2024-07-09',
        ]);

        Curriculum::factory()->create([
            'classroom_id' => 1,
            'lecture_id' => 3,
            'audition_date' => '2024-07-10',
        ]);

        Curriculum::factory()->create([
            'classroom_id' => 2,
            'lecture_id' => 3,
            'audition_date' => '2024-07-08',
        ]);

        Curriculum::factory()->create([
            'classroom_id' => 2,
            'lecture_id' => 1,
            'audition_date' => '2024-07-09',
        ]);

        Curriculum::factory()->create([
            'classroom_id' => 2,
            'lecture_id' => 2,
            'audition_date' => '2024-07-10',
        ]);


        Curriculum::factory()->create([
            'classroom_id' => 3,
            'lecture_id' => 2,
            'audition_date' => '2024-07-08',
        ]);

        Curriculum::factory()->create([
            'classroom_id' => 3,
            'lecture_id' => 3,
            'audition_date' => '2024-07-09',
        ]);

        Curriculum::factory()->create([
            'classroom_id' => 3,
            'lecture_id' => 1,
            'audition_date' => '2024-07-10',
        ]);
    }
}
