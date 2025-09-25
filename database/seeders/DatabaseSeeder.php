<?php

namespace Database\Seeders;

use App\Models\Registration;
use App\Models\Application;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create sample registrations
        $registrations = [
            [
                'first_name' => 'Van A',
                'last_name' => 'Nguyen',
                'email' => 'nguyenvana@example.com',
                'phone' => '0901234567',
                'gender' => 'male',
                'date_of_birth' => '2000-05-15',
                'country_of_birth' => 'Vietnam',
                'nationality' => 'Vietnamese',
                'passport_no' => 'N1234567',
                'permanent_address' => '123 Le Loi, District 1, Ho Chi Minh City',
                'present_address' => '456 Nguyen Trai, District 5, Ho Chi Minh City',
                'program' => 'Computer Science'
            ],
            [
                'first_name' => 'Thi B',
                'last_name' => 'Tran',
                'email' => 'tranthib@example.com',
                'phone' => '0912345678',
                'gender' => 'female',
                'date_of_birth' => '1999-08-20',
                'country_of_birth' => 'Vietnam',
                'nationality' => 'Vietnamese',
                'passport_no' => 'N2345678',
                'permanent_address' => '789 Tran Hung Dao, District 3, Ho Chi Minh City',
                'present_address' => '321 Vo Thi Sau, District 3, Ho Chi Minh City',
                'program' => 'Business Administration'
            ],
            [
                'first_name' => 'Van C',
                'last_name' => 'Le',
                'email' => 'levanc@example.com',
                'phone' => '0923456789',
                'gender' => 'male',
                'date_of_birth' => '2001-03-10',
                'country_of_birth' => 'Vietnam',
                'nationality' => 'Vietnamese',
                'passport_no' => 'N3456789',
                'permanent_address' => '555 Hai Ba Trung, District 1, Ho Chi Minh City',
                'present_address' => '777 Dong Khoi, District 1, Ho Chi Minh City',
                'program' => 'Engineering'
            ],
            [
                'first_name' => 'Thi D',
                'last_name' => 'Pham',
                'email' => 'phamthid@example.com',
                'phone' => '0934567890',
                'gender' => 'female',
                'date_of_birth' => '2000-12-25',
                'country_of_birth' => 'Vietnam',
                'nationality' => 'Vietnamese',
                'passport_no' => 'N4567890',
                'permanent_address' => '888 Nguyen Hue, District 1, Ho Chi Minh City',
                'present_address' => '999 Le Thanh Ton, District 1, Ho Chi Minh City',
                'program' => 'Economics'
            ]
        ];

        foreach ($registrations as $regData) {
            $registration = Registration::create($regData);
            
            // Tự động tạo application cho mỗi registration (giống như nút Next)
            Application::createFromRegistration($registration->id, [
                'status' => collect(['submitted', 'approved', 'enrolled'])->random(),
                'payment_status' => collect(['unpaid', 'partial', 'paid'])->random()
            ]);
        }
    }
}
