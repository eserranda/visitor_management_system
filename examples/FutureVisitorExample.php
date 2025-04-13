<?php

// Membuat data baru
$futureVisitor = new \App\Models\FutureVisitor();
$futureVisitor->user_id = 1;
$futureVisitor->visitor_name = "Budi Santoso";
$futureVisitor->arrival_date = "2023-06-15"; // Otomatis dikonversi ke Carbon date
$futureVisitor->estimated_arrival_time = "14:30:00"; // Otomatis dikonversi ke Carbon time
$futureVisitor->vehicle_number = "B 1234 CD";
$futureVisitor->save();

// Atau menggunakan create
$data = \App\Models\FutureVisitor::create([
    'user_id' => 2,
    'visitor_name' => 'Siti Rahayu',
    'arrival_date' => '2023-06-16',
    'estimated_arrival_time' => '09:15:00',
    'vehicle_number' => 'D 5678 EF'
]);

// Mendapatkan semua data
$visitors = \App\Models\FutureVisitor::all();

// Mendapatkan data dengan filter
$todayVisitors = \App\Models\FutureVisitor::whereDate('arrival_date', now())->get();

// Menggunakan relasi user
$visitor = \App\Models\FutureVisitor::find(1);
$userName = $visitor->user->name;

// Contoh penggunaan cast date
$visitor = \App\Models\FutureVisitor::first();
echo $visitor->arrival_date->format('d F Y'); // Misal: "15 Juni 2023"
echo $visitor->estimated_arrival_time->format('H:i'); // Misal: "14:30"

// Cek apakah kunjungan hari ini
if ($visitor->arrival_date->isToday()) {
    echo "Kunjungan hari ini!";
}

// Menambahkan 1 hari ke tanggal kunjungan
$visitor->arrival_date = $visitor->arrival_date->addDay();
$visitor->save();
