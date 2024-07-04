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
            // 'email' => '1122@gmail.com',
            'email' => 'edmundngxhunyan@gmail.com',
            'password' => bcrypt('password'),
            'faculty' => 'FCI',
            'photo' => 'https://randomuser.me/api/portraits/men/3.jpg',
            'program' => 'CS'
        ]);
        Student::create([
            'id' => "1234",
            'name' => 'Johnny G',
            'email' => '1234@gmail.com',
            'password' => bcrypt('password'),
            'faculty' => 'FCI',
            'photo' => 'https://randomuser.me/api/portraits/women/3.jpg',
            'program' => 'CS'
        ]);
        Student::create([
            'id' => "3322",
            'name' => 'El Negro',
            'email' => 'negg@gmail.com',
            'password' => bcrypt('password'),
            'faculty' => 'FOM',
            'photo' => 'https://randomuser.me/api/portraits/men/42.jpg',
            'program' => 'LAW'
        ]);
        Student::create([
            'id' => "3344",
            'name' => 'Edmund Lemon',
            'email' => 'elm@gmail.com',
            'password' => bcrypt('password'),
            'faculty' => 'FOE',
            'photo' => 'https://randomuser.me/api/portraits/men/88.jpg',
            'program' => 'EG'
        ]);
        Lecturer::create([
            'id' => 'MU1234',
            'name' => 'Jane Doe',
            'email' => 'mu1234@gmail.com',
            'password' => bcrypt('password'),
            'photo' => 'https://randomuser.me/api/portraits/men/5.jpg',
            'faculty' => 'FCI',
            'office' => 'A-123',
        ]);
        Lecturer::create([
            'id' => 'MU1212',
            'name' => 'Jane Hello',
            'email' => 'mu1212@gmail.com',
            'password' => bcrypt('password'),
            'photo' => 'https://randomuser.me/api/portraits/women/7.jpg',
            'faculty' => 'FCI',
            'office' => 'A-133',
        ]);
        Lecturer::create([
            'id' => 'MU2233',
            'name' => 'Jane Bye',
            'email' => 'mu2233@gmail.com',
            'password' => bcrypt('password'),
            'photo' => 'https://randomuser.me/api/portraits/women/11.jpg',
            'faculty' => 'FOE',
            'office' => 'B-123',
        ]);
        Lecturer::create([
            'id' => 'MU3322',
            'name' => 'Ray Bye',
            'email' => 'zaza@gmail.com',
            'password' => bcrypt('password'),
            'photo' => 'https://randomuser.me/api/portraits/men/2.jpg',
            'faculty' => 'FCM',
            'office' => 'C-123',
        ]);
        Lecturer::create([
            'id' => 'MU4433',
            'name' => 'Kai Cenat',
            'email' => 'kc2233@gmail.com',
            'password' => bcrypt('password'),
            'photo' => 'https://randomuser.me/api/portraits/men/59.jpg',
            'faculty' => 'FCA',
            'office' => 'C-223',
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
            'start_time' => Carbon::today()->addDays(2)->setHour(10)->setMinute(0)->format('H:i'),
            'end_time' => Carbon::today()->addDays(2)->setHour(11)->setMinute(0)->format('H:i'),
            'status' => 'Approved',
            'topic' => 'Maths'
        ]);
        Consultation_slot::create([
            // 'id' => test,
            'lecturer_id' => 'MU1234',
            'student_id' =>"1122",
            'date' => Carbon::today(),
            'start_time' => Carbon::now()->addMinutes(15)->format('H:i'),
            'end_time' => Carbon::now()->addMinute(15)->format('H:i'),
            'status' => 'Approved',
            'topic' => 'Maths'
        ]);
        Consultation_slot::create([
            // 'id' => 2,
            'lecturer_id' => 'MU1234',
            'student_id' =>"1122",
            'date' => Carbon::today()->addDays(-5),
            'start_time' => Carbon::now()->addMinutes(-25)->format('H:i'),
            'end_time' => Carbon::now()->addMinutes(-75)->format('H:i'),
            'status' => 'Pending'
        ]);
        Consultation_slot::create([
            // 'id' => 2,
            'lecturer_id' => 'MU1234',
            'student_id' =>"1122",
            'date' => Carbon::today()->addDays(4),
            'start_time' => Carbon::now()->addMinutes(25)->format('H:i'),
            'end_time' => Carbon::now()->addMinutes(75)->format('H:i'),
            'status' => 'Pending'
        ]);
        Consultation_slot::create([
            // 'id' => 2,
            'lecturer_id' => 'MU1234',
            'student_id' =>"1122",
            'date' => Carbon::today()->addDays(2),
            'start_time' => Carbon::today()->setHour(10)->setMinute(30)->format('H:i'),
            'end_time' => Carbon::today()->setHour(11)->setMinute(30)->format('H:i'),
            'status' => 'Pending'
        ]);
        Free_slot::create([
            'id' => 1,
            'lecturer_id' => 'MU1234',
            'date' => Carbon::now()->next(Carbon::WEDNESDAY),
            'start_time' => Carbon::now()->setHour(10)->setMinute(0)->format('H:i'),
            'end_time' => Carbon::now()->setHour(11)->setMinute(0)->format('H:i'),
        ]);

        Free_slot::create([
            'id' => 2,
            'lecturer_id' => 'MU1234',
            'date' => Carbon::now()->next(Carbon::MONDAY),
            'start_time' => Carbon::now()->setHour(10)->setMinute(0)->format('H:i'),
            'end_time' => Carbon::now()->setHour(11)->setMinute(0)->format('H:i'),
        ]);

        Free_slot::create([
            'id' => 3,
            'lecturer_id' => 'MU1212',
            'date' => Carbon::now()->next(Carbon::MONDAY),
            'start_time' => Carbon::now()->setHour(13)->setMinute(0)->format('H:i'),
            'end_time' => Carbon::now()->setHour(14)->setMinute(0)->format('H:i'),
        ]);
        Free_slot::create([
            'id' => 4,
            'lecturer_id' => 'MU1234',
            'date' => Carbon::now()->next(Carbon::WEDNESDAY),
            'start_time' => Carbon::now()->setHour(12)->setMinute(0)->format('H:i'),
            'end_time' => Carbon::now()->setHour(13)->setMinute(0)->format('H:i'),
        ]);
        Free_slot::create([
            'id' => 5,
            'lecturer_id' => 'MU1234',
            'date' => Carbon::now()->next(Carbon::THURSDAY),
            'start_time' => Carbon::now()->setHour(11)->setMinute(0)->format('H:i'),
            'end_time' => Carbon::now()->setHour(13)->setMinute(0)->format('H:i'),
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}