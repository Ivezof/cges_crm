<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Order;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $clients = Client::factory()->count(50)->create();
        $orders = Order::factory()->count(30)->create();
    }
}
