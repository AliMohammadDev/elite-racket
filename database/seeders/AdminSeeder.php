<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
    $adminRole = Role::firstOrCreate(['name' => 'admin']);

    $superAdmin = User::firstOrCreate(
      ['email' => 'admin@gmail.com'],
      [
        'name' => 'مدير النظام الرئيسي',
        'password' => Hash::make('password'),
        'is_active' => true,
      ]
    );
    $superAdmin->assignRole($superAdminRole);
  }
}
