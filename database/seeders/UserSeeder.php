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
      ['name' => 'أحمد محمد', 'email' => 'ahmed@example.com'],
      ['name' => 'سارة الأحمد', 'email' => 'sara@example.com'],
      ['name' => 'ياسين نوري', 'email' => 'yassin@example.com'],
      ['name' => 'ليلى محمود', 'email' => 'layla@example.com'],
      ['name' => 'عمر خالد', 'email' => 'omar@example.com'],
      ['name' => 'فاطمة الزهراء', 'email' => 'fatima@example.com'],
      ['name' => 'محمود ياسر', 'email' => 'mahmoud@example.com'],
      ['name' => 'نور الهدى', 'email' => 'nour@example.com'],
      ['name' => 'حمزة العلي', 'email' => 'hamza@example.com'],
      ['name' => 'ريم القاسم', 'email' => 'reem@example.com'],
    ];

    foreach ($users as $userData) {
      $user = User::firstOrCreate(
        ['email' => $userData['email']],
        [
          'name' => $userData['name'],
          'password' => Hash::make('password'),
          'is_active' => true,
        ]
      );

      $user->assignRole('customer');
    }
  }
}
