<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;
use App\Models\Review;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Free_slot;
use Illuminate\Database\Seeder;
use App\Models\Consultation_slot;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Student::create([
            'id' =>"1122",
            'name' => 'John Doe',
            'email' => '1122@gmail.com',
            'password' => bcrypt('password'),
            'faculty' => 'FCI',
            'photo' => 'https://via.placeholder.com/150',
            'program' => 'CS'
        ]);
        Student::create([
            'id' => "ST1234",
            'name' => 'Johnny G',
            'email' => '1234@gmail.com',
            'password' => bcrypt('password'),
            'faculty' => 'FCI',
            'photo' => 'https://via.placeholder.com/150',
            'program' => 'CS'
        ]);
        Lecturer::create([
            'id' => 'MU1234',
            'name' => 'Jane Doe',
            'email' => 'mu1234@gmail.com',
            'password' => bcrypt('password'),
            'photo' => 'https://via.placeholder.com/150',
            'faculty' => 'FCI'
        ]);
        Lecturer::create([
            'id' => 'MU1212',
            'name' => 'Jane Hello',
            'email' => 'mu1212@gmail.com',
            'password' => bcrypt('password'),
            'photo' => 'https://via.placeholder.com/150',
            'faculty' => 'FCI'
        ]);
        Admin::create([
            'id' => 'AD1234',
            'name' => 'Admin',
            'email' => 'ad1234@gmail.com',
            'password' => bcrypt('password')
        ]);
        Review::create([
            'id' => 1,
            'lecturer_id' => 'MU1234',
            'student_id' =>"1122",
            'rating' => '5',
            'comment' => 'Great'
        ]);
        Consultation_slot::create([
            // 'id' => 1,
            'lecturer_id' => 'MU1234',
            'student_id' =>"1122",
            'date' => Carbon::today()->addDays(2),
            'start_time' => Carbon::now()->addMinutes(30)->format('H:i'),
            // ...

            'end_time' => Carbon::now()->addMinutes(90)->format('H:i'),
            'status' => 'accepted'
        ]);
        Consultation_slot::create([
            // 'id' => 2,
            'lecturer_id' => 'MU1234',
            'student_id' =>"1122",
            'date' => Carbon::today()->addDays(3),
            'start_time' => Carbon::now()->addMinutes(25)->format('H:i'),
            // ...

            'end_time' => Carbon::now()->addMinutes(75)->format('H:i'),
            'status' => 'booked'
        ]);
        Free_slot::create([
            'id' => 1,
            'lecturer_id' => 'MU1234',
            'date' => Carbon::now()->addDays(2),
            'start_time' => Carbon::now()->addDays(2)->setHour(10)->setMinute(0)->format('H:i'),
            'end_time' => Carbon::now()->addDays(2)->setHour(11)->setMinute(0)->format('H:i'),
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
