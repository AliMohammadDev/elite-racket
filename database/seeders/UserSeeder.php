<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {

    $customerRole = Role::firstOrCreate(['name' => 'customer']);

    $users = [
      ['name' => 'أحمد محمد', 'email' => 'ahmed@example.com', 'phone' => '0501234561'],
      ['name' => 'سارة الأحمد', 'email' => 'sara@example.com', 'phone' => '0501234562'],
      ['name' => 'ياسين نوري', 'email' => 'yassin@example.com', 'phone' => '0501234563'],
      ['name' => 'ليلى محمود', 'email' => 'layla@example.com', 'phone' => '0501234564'],
      ['name' => 'عمر خالد', 'email' => 'omar@example.com', 'phone' => '0501234565'],
      ['name' => 'فاطمة الزهراء', 'email' => 'fatima@example.com', 'phone' => '0501234566'],
      ['name' => 'محمود ياسر', 'email' => 'mahmoud@example.com', 'phone' => '0501234567'],
      ['name' => 'نور الهدى', 'email' => 'nour@example.com', 'phone' => '0501234568'],
      ['name' => 'حمزة العلي', 'email' => 'hamza@example.com', 'phone' => '0501234569'],
      ['name' => 'ريم القاسم', 'email' => 'reem@example.com', 'phone' => '0501234570'],
    ];
    foreach ($users as $userData) {
      $user = User::firstOrCreate(
        ['email' => $userData['email']],
        [
          'name' => $userData['name'],
          'phone' => $userData['phone'],
          'password' => Hash::make('password'),
          'is_active' => true,
          'email_verified_at' => now(),
        ]
      );

      if (!$user->hasRole('customer')) {
        $user->assignRole($customerRole);
      }
    }
  }
}