<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;
use App\Models\User;

class RestaurantSeeder extends Seeder
{
    public function run()
    {
        $admin = User::factory()->create()->assignRole('admin');

        Restaurant::create([
            'name' => 'Café de la Opera',
            'address' => 'La Rambla, 74, 08002 Barcelona',
            'phone' => '555-3456',
            'user_id' => $admin->id,
        ]);

        Restaurant::create([
            'name' => 'Tickets',
            'address' => 'Avinguda del Paral·lel, 164, 08015 Barcelona',
            'phone' => '555-7890',
            'user_id' => $admin->id,
        ]);

        Restaurant::create([
            'name' => 'El Celler de Can Roca',
            'address' => 'Carrer de Can Sunyer, 48, 17007 Girona',
            'phone' => '555-4321',
            'user_id' => $admin->id,
        ]);

        Restaurant::create([
            'name' => 'Bovino',
            'address' => 'Carrer de Pau Claris, 91, 08010 Barcelona',
            'phone' => '555-8888',
            'user_id' => $admin->id,
        ]);

        Restaurant::create([
            'name' => 'Cervecería Catalana',
            'address' => 'Carrer de Mallorca, 236, 08008 Barcelona',
            'phone' => '555-6543',
            'user_id' => $admin->id,
        ]);

        Restaurant::create([
            'name' => 'Bar Tomás',
            'address' => 'Carrer de Carles III, 34, 08028 Barcelona',
            'phone' => '555-2211',
            'user_id' => $admin->id,
        ]);

        Restaurant::create([
            'name' => 'Can Majó',
            'address' => 'Carrer de l’Almirall Aixada, 23, 08003 Barcelona',
            'phone' => '555-9988',
            'user_id' => $admin->id,
        ]);

    }
}
