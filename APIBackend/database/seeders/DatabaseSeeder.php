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
            'id' => "1122",
            'name' => 'John Doe',
            'email' => '1122@gmail.com',
            'password' => bcrypt('password'),
            'faculty' => 'FCI',
            'photo' => 'https://via.placeholder.com/150',
            'program' => 'CS'
        ]);
        Student::create([
            'id' => "1234",
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
            'faculty' => 'FCI',
            'office' => 'BR-4013'
        ]);
        Lecturer::create([
            'id' => 'MU1212',
            'name' => 'Jane Hello',
            'email' => 'mu1212@gmail.com',
            'password' => bcrypt('password'),
            'photo' => 'https://via.placeholder.com/150',
            'faculty' => 'FCI'
        ]);
        Lecturer::create([
            'id' => 'MU4321',
            'name' => 'Joe Mumma',
            'email' => 'mumma1@gmail.com',
            'password' => bcrypt('password'),
            'photo' => 'https://via.placeholder.com/150',
            'faculty' => 'FOL',
            'office' => 'BR-3222'
        ]);
        Lecturer::create([
            'id' => 'MU2233',
            'name' => 'Deez NUTS',
            'email' => 'deez2@gmail.com',
            'password' => bcrypt('password'),
            'photo' => 'https://via.placeholder.com/150',
            'faculty' => 'FOM',
            'office' => 'BR-2032'
        ]);
        Lecturer::create([
            'id' => 'MU3344',
            'name' => 'Zane Malik',
            'email' => 'zanny@gmail.com',
            'password' => bcrypt('password'),
            'photo' => 'https://via.placeholder.com/150',
            'faculty' => 'FCM',
            'office' => 'BR-4322'
        ]);
        Lecturer::create([
            'id' => 'MU4455',
            'name' => 'Edmund Lemon',
            'email' => 'edlm@gmail.com',
            'password' => bcrypt('password'),
            'photo' => 'https://via.placeholder.com/150',
            'faculty' => 'FOE',
            'office' => 'CR-3242'
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
            'student_id' => "1122",
            'rating' => '5',
            'comment' => 'Great'
        ]);
        Lecturer::create([
            'id' => 'MU1212',
            'name' => 'Jane Hello',
            'email' => 'mu1212@gmail.com',
            'password' => bcrypt('password'),
            'photo' => 'https://via.placeholder.com/150',
            'faculty' => 'FCI'
        ]);
        Review::create([
            'id' => 2,
            'lecturer_id' => 'MU1234',
            'student_id' => "1122",
            'rating' => '3',
            'comment' => 'Great'
        ]);
        Consultation_slot::create([
            // 'id' => 1,
            'lecturer_id' => 'MU1234',
            'student_id' => "1122",
            'date' => Carbon::today()->addDays(2),
            'start_time' => Carbon::now()->addMinutes(30)->format('H:i'),
            'end_time' => Carbon::now()->addMinutes(90)->format('H:i'),
            'status' => 'Approved'
        ]);
        Consultation_slot::create([
            // 'id' => 2,
            'lecturer_id' => 'MU1234',
            'student_id' => "1122",
            'date' => Carbon::today(),
            'start_time' => Carbon::now()->addMinutes(25)->format('H:i'),
            'end_time' => Carbon::now()->addMinutes(75)->format('H:i'),
            'status' => 'Pending'
        ]);
        Consultation_slot::create([
            // 'id' => 2,
            'lecturer_id' => 'MU1234',
            'student_id' => "1122",
            'date' => Carbon::today()->addDay(),
            'start_time' => Carbon::now()->addMinutes(25)->format('H:i'),
            'end_time' => Carbon::now()->addMinutes(75)->format('H:i'),
            'status' => 'Pending'
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
