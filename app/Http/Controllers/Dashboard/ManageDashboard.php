<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageDashboard extends Controller
{
    public function index()
    {
        $countClients = DB::table('clients')
            ->whereNull('deleted_at')
            ->selectRaw('COUNT(id) AS count')
            ->when(auth()->user()->hasRole('simple'), function ($q) {
                return $q->where('user_id', auth()->user()->id);
            })
            ->first();
        $countProjects = DB::table('projects')
            ->whereNull('deleted_at')
            ->selectRaw('COUNT(id) AS count')
            ->when(auth()->user()->hasRole('simple'), function ($q) {
                return $q->where('user_id', auth()->user()->id);
            })
            ->first();
        $countTasks = DB::table('tasks')
            ->whereNull('deleted_at')
            ->selectRaw('COUNT(id) AS count')
            ->when(auth()->user()->hasRole('simple'), function ($q) {
                return $q->where('user_id', auth()->user()->id);
            })
            ->first();
        $countNotDoneProjects = DB::table('projects')
            ->whereNull('deleted_at')
            ->selectRaw('COUNT(id) AS count')
            ->where('deadline', '<=', date('Y-m-d'))
            ->whereNot('status', 'done')
            ->when(auth()->user()->hasRole('simple'), function ($q) {
                return $q->where('user_id', auth()->user()->id);
            })
            ->first();

        return view('src.dashboard.index', [
            'count_clients' => $countClients->count,
            'count_projects' => $countProjects->count,
            'count_tasks' => $countTasks->count,
            'count_not_done_projects' => $countNotDoneProjects->count
        ]);
    }
}
