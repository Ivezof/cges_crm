<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use App\Models\Payments;
use App\Models\User;
use Barryvdh\Debugbar\Facades\Debugbar;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getStats(Request $request) {
        // 0 - в обработке
        // 1 - ожидает платежа
        // 2 - активный
        // 3 - на проверке
        // 4 - выполнен
        // 5 - отменен
        $fromtime = Carbon::createFromTimestamp($request->get('from'))->toDate();
        $totime = Carbon::createFromTimestamp($request->get('to'))->toDate(); // http://127.0.0.1:8000/api/getStats?from=1716854400&to=1716940800

        $complete = Order::whereBetween('created_at', [$fromtime, $totime])->where('status', '=', 4)->get();
        $active = Order::whereBetween('created_at', [$fromtime, $totime])->where('status', '=', 2)->get();
        $canceled = Order::whereBetween('created_at', [$fromtime, $totime])->where('status', '=', 5)->get();
        $oncheck = Order::whereBetween('created_at', [$fromtime, $totime])->where('status', '=', 3)->get();

        $data = ['completed' => count($complete), 'canceled' => count($canceled),
            'active' => count($active), 'oncheck' => count($oncheck)];
        return response()->json($data);
    }

    public function getAllOrders(Request $request) {
        $orders = Order::with('client')->with('workers')->with('payment')->orderByDesc('id')->get();
        return response()->json($orders, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function getOrder($id) {
        return response()->json(Order::find($id), 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function getOrders(Request $request) {
        $fromtime = Carbon::createFromTimestamp($request->get('from'))->toDate();
        $totime = Carbon::createFromTimestamp($request->get('to'))->toDate();

        $orders = Order::whereBetween('created_at', [$fromtime, $totime])->where('status', '=', 4)->
        where('spent', '>', 0)->orderBy('created_at')->get();
        return response()->json($orders, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE); // http://127.0.0.1:8000/api/getOrders?from=1715087267&to=1717679267
    }

    public function getClients(Request $request) {
        $per_page = 10;
        if ($request->get('perPage')) {
            $per_page = $request->get('perPage');
        }
        $order_by = $request->get('orderBy')[0];
        $order_by_type = $request->get('orderBy')[1];
        $current_page = $request->get('page');
        if ($order_by == 'orders_count') {
            $clients = Client::all();
            if ($order_by_type == 'asc') {
                $sorted = $clients->sortBy(function ($client) {
                    return $client->getOrdersCountAttribute();
                })->values();
            } elseif ($order_by_type == 'desc') {
                $sorted = $clients->sortByDesc(function ($client) {

                    return $client->getOrdersCountAttribute();
                });
            }

            $paginator = new \Illuminate\Pagination\LengthAwarePaginator($sorted->slice(($current_page - 1) * $per_page , $per_page)->values()->all(), $sorted->count(), $per_page, $current_page, ['path' => request()->url(), 'query' => request()->query()]);
            return $paginator;
        } else {
            return Client::with('orders')->orderBy($order_by, $order_by_type)->paginate($per_page);
        }


    }

    public function deleteClients(Request $request): JsonResponse
    {
        $clients = $request->get('client');
        $clients_controller = new ClientsController();
        $client_not_found = [];
        foreach ($clients as $client) {
            $result = $clients_controller->deleteClient(number_format($client['id']));
            if ($result === null) {
                $client_not_found[] = $client['id'];
            }
        }
        return response()->json(['clients' => $clients, 'not_found' => ["id" => $client_not_found]], 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function getClient(Request $request) {
        $client_id = $request->get('id');
        $clients_controller = new ClientsController();
        $client = $clients_controller->getClient($client_id);
        return response()->json(['client' => $client], 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }


    public function clientUpdate(Request $request)
    {
        $client_controller = new ClientsController();
        $client_obj = ['id' => $request->get('id'), 'fio' => $request->get('fio'), 'email' => $request->get('email'), 'phone' => $request->get('phone'), 'telegram' => $request->get('telegram')];
        $client = $client_controller->updateClient($client_obj);

        return response()->json(['client' => $client], 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }






    public function getPayments(Request $request): JsonResponse
    {
        $per_page = 10;
        if ($request->get('perPage')) {
            $per_page = $request->get('perPage');
        }
        $order_by = $request->get('orderBy')[0];
        $order_by_type = $request->get('orderBy')[1];
        $payments = Payments::with('Order')->orderBy($order_by, $order_by_type)->paginate($per_page);
        return response()->json($payments, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function deletePayments(Request $request): JsonResponse
    {
        $payments = $request->get('payments');
        $payment_controller = new PaymentsController();
        $payment_not_found = [];
        foreach ($payments as $payment) {
            $result = $payment_controller->deletePayment(number_format($payment['id']));
            if ($result === null) {
                $payment_not_found[] = $payment['id'];
            }
        }
        return response()->json(['payments' => $payments, 'not_found' => ["id" => $payment_not_found]], 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function paymentUpdate(Request $request): JsonResponse
    {
        $payment_contoller = new PaymentsController();
        $payment_obj = ['id' => $request->get('id'), 'sum' => $request->get('sum'), 'paid' => $request->get('paid')];
        $payment = $payment_contoller->updatePayment($payment_obj);

        return response()->json(['payments' => $payment], 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function getPayment(Request $request): JsonResponse
    {
        $payment_id = $request->get('id');
        $payment_controller = new PaymentsController();
        $payment = $payment_controller->getPayment($payment_id);
        return response()->json(['payments' => $payment], 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }


    public function getWorkers(Request $request): JsonResponse
    {
        $per_page = 10;
        if ($request->get('perPage')) {
            $per_page = $request->get('perPage');
        }
        $workers = User::paginate($per_page);
        return response()->json($workers, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function deleteWorker(Request $request): JsonResponse
    {
        $workers = $request->get('workers');
        $worker_controller = new WorkersController();
        $worker_not_found = [];
        foreach ($workers as $worker) {
            $result = $worker_controller->deleteWorker(number_format($worker['id']));
            if ($result === null) {
                $worker_not_found[] = $worker['id'];
            }
        }
        return response()->json(['payments' => $workers, 'not_found' => ["id" => $worker_not_found]], 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function workerUpdate(Request $request): JsonResponse
    {
        $worker_controller = new WorkersController();
        $worker_obj = ['id' => $request->get('id'), 'name' => $request->get('name'), 'email' => $request->get('email')];
        $worker = $worker_controller->updateWorker($worker_obj);

        return response()->json(['workers' => $worker], 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function getWorker(Request $request): JsonResponse
    {
        $worker_id = $request->get('id');
        $worker_controller = new WorkersController();
        $worker = $worker_controller->getWorker($worker_id);
        return response()->json(['workers' => $worker], 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function getAllWorkers(): JsonResponse
    {
        $worker_controller = new WorkersController();
        return response()->json(['workers' => $worker_controller->getAllWorkers()], 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }


    public function orderUpdate(Request $request) {
        $order_id = $request->get('order_id');
        $description = $request->get('description');
        $address = $request->get('address');
        $budget = $request->get('budget');
        $spent = $request->get('spent');
        $workers = $request->get('workers');
        $status = $request->get('status');
        $payment_status = $request->get('payment_status');

        Debugbar::info($spent);

        $order = Order::find($order_id);
        if ($description) {
            $order->description = $description;
        }

        if ($address) {
            $order->address = $address;
        }
        if ($budget) {
            $order->budget = $budget;
        }
        if ($spent) {
            $order->spent = $spent;
        }
        if ($workers) {
            foreach ($workers as $worker) {
                $order->workers()->attach($worker);
            }
        }

        $order->status = $status;
        $order->payment()->update(['paid' => $payment_status]);
        $order->save();
    }


}
