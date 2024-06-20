<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;

class WorkersController extends Controller
{
    public function getWorkers(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('workers.workers');
    }

    public function getWorker($id): Model|Collection|array|Payments|null
    {
        return User::find($id);
    }

    public function getAllWorkers(): Collection
    {
        return User::where('role', '=', 0)->get();
    }

    public function deleteWorker(int $worker_id): ?bool
    {
        $worker = User::find($worker_id);
        return $worker->delete();
    }

    public function updateWorker($worker_obj): Model|Collection|array|Payments|null
    {
        $worker = User::find($worker_obj['id']);

        $worker->name = $worker_obj['name'];
        $worker->email = $worker_obj['email'];
        $worker->save();
        return $worker;
    }
}
