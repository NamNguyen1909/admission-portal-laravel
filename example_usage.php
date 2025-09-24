<?php

// Ví dụ về cách tạo Application từ Registration

// CÁCH 1: Tự động lấy thông tin khi tạo Application
// Khi bạn tạo Application và chỉ cần cung cấp registration_id,
// student_name và program sẽ tự động được lấy từ Registration

$application = Application::create([
    'registration_id' => 1, // ID của Registration
    'status' => 'submitted',
    'payment_status' => 'unpaid'
    // student_name và program sẽ TỰ ĐỘNG được lấy từ Registration có id = 1
    // application_id cũng sẽ TỰ ĐỘNG được sinh (APP-2025-0001)
]);

// CÁCH 2: Sử dụng method tiện lợi
$application = Application::createFromRegistration(1, [
    'status' => 'submitted',
    'payment_status' => 'unpaid'
]);

// CÁCH 3: Tạo qua relationship (từ Registration)
$registration = Registration::find(1);
$application = $registration->applications()->create([
    'status' => 'submitted', 
    'payment_status' => 'unpaid'
    // registration_id, student_name, program sẽ tự động được set
]);

// Kết quả: 
// - application_id: APP-2025-0001 (tự sinh)
// - student_name: "Nguyen Van A" (lấy từ Registration)  
// - program: "Computer Science" (lấy từ Registration)
// - registration_id: 1
// - status: submitted
// - payment_status: unpaid

echo "Application created: " . $application->application_id;
echo "Student: " . $application->student_name;
echo "Program: " . $application->program;