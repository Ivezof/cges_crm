<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index() {
        return view('orders.orders');
    }

    public function createOrder($client_id, $description, $address, $status) {
        $order = new Order;
        $order->client_id = $client_id;
        $order->description = $description;
        $order->address = $address;
        $order->status = $status;
        $order->endOrder = date('y.m.d H.i.s', strtotime('+7 day'));
        $order->save();
        $order->payment()->create([
            'order_id' => $order->id,
            'paid' => false
        ]);

        return $order;
    }
}
