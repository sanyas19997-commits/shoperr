<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@shophub.test'],
            [
                'name' => 'Администратор',
                'password' => 'password',
                'role' => 'admin',
                'phone' => '+7 (900) 000-00-00',
                'address' => 'Москва, ул. Примерная, 1',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@shophub.test'],
            [
                'name' => 'Иван Иванов',
                'password' => 'password',
                'role' => 'user',
                'phone' => '+7 (900) 000-11-22',
                'address' => 'Санкт-Петербург, Невский пр., 1',
            ]
        );
    }
}
