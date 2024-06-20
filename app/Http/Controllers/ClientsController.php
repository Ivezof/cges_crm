<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\Order;
use App\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class ClientsController extends Controller
{
    public function index() {
        return view('clients.clients');
    }

    public function deleteClient(int $client_id) {
        $client = Client::find($client_id);
        if ($client === null) {
            return null;
        }
        return $client->delete();
    }

    public function updateClient($client_obj) {
        $client = Client::find($client_obj['id']);

        $client->fio = $client_obj['fio'];
        $client->email = $client_obj['email'];
        $client->phone = $client_obj['phone'];
        $client->telegram = $client_obj['telegram'];
        $client->save();
        return $client;
    }

    public function getClient($id) {
        return Client::find($id);
    }

    public function addOrder(ClientRequest $request) {
        if (!Client::where('email', '=', $request->email)->exists()) {
            $client = Client::create([
                'fio' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'telegram' => $request->telegram,
                'email_verify_hashcode' => Str::random(30)
            ]);
        } else {
            $client = Client::where('email', '=', $request->email)->first();
        }

        $verify = $this->verifyEmail($client);
        $orders_controller = new OrdersController;
        $orders_controller->createOrder($client->id, $request->description, $request->address, $verify ? 0 : -1);
        return response()->json(['verified' => $verify]);
    }
    public function verifyEmail(Client $client): bool
    {
        if (Client::where('email', '=', $client->email)->where('email_verify', '=', true)->exists()) {
            return true;
        }
        $hashcode = $client->email_verify_hashcode;
        Notification::route('mail', $client->email)->notify(new VerifyEmail($hashcode));
        return false;
    }

    public function verify($code) {
        $client = Client::where('email_verify_hashcode', '=', $code)->first();
        if (isset($client) and $client->email_verify_hashcode == $code and !$client->email_verify) {
            $client->email_verify = true;
            $client->save();
            Order::where('client_id', '=', $client->id)->update(['status' => 0]);
            return redirect()->route('client.form', ['verified' => '?verified=true']);
        }
        return '<p>Код не найден, попробуйте еще раз</p>';
    }
}
