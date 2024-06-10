<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{


    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('payments.payments');
    }

    public function getPayment($id): Model|Collection|array|Payments|null
    {
        return Payments::find($id);
    }

    public function deletePayment(int $payment_id): ?bool
    {
        $payment = Payments::find($payment_id);
        return $payment?->delete();
    }

    public function updatePayment($payment_obj): Model|Collection|array|Payments|null
    {
        $payment = Payments::find($payment_obj['id']);

        $payment->sum = $payment_obj['sum'];
        $payment->paid = $payment_obj['paid'];
        $payment->save();
        return $payment;
    }
}
