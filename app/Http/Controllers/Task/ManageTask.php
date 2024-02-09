<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Mail\TaskMail;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ManageTask extends Controller
{
    # VALIDATOR FOR VALIDATE
    public function validator($request)
    {
        $dataRequest = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'nullable',
            'deadline' => 'required|date',
            'user_id' => 'nullable|integer',
            'client_id' => 'required|integer',
            'project_id' => 'required|integer',
            'status' => 'required',
        ]);

        if ($dataRequest->fails()) {
            abort(back()->withErrors($dataRequest)->withInput());
        }

        return $dataRequest;
    }

    # PRIVATE
    private $statuses = ['open', 'on', 'off', 'done'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            # query data
            $datatables = DB::table('tasks AS t')
                ->leftJoin('view_data_users AS u', 'u.id', 't.user_id')
                ->leftJoin('clients AS c', 'c.id', 't.client_id')
                ->leftJoin('projects AS p', 'p.id', 't.project_id')
                ->select('t.*', 'c.contact_name', 'u.user_full_name AS user_name', 'p.title AS project_name')
                ->whereNull('t.deleted_at')
                ->when(auth()->user()->hasRole('simple'), function ($q) {
                    return $q->where('t.user_id', auth()->user()->id);
                })
                ->orderBy('t.deadline', 'ASC');

                
            $exceptActions = ['show'];

            return DataTables::of($datatables)
                ->filter(function ($q) use ($request) {
                    if ($request->search['value']) {
                        $q = $q->where('t.title', 'LIKE', ("%" . $request->search['value'] . "%"))
                            ->orWhere('u.user_full_name', 'LIKE', ("%" . $request->search['value'] . "%"))
                            ->orWhere('c.contact_name', 'LIKE', ("%" . $request->search['value'] . "%"));
                    }

                    if ($request->filterStart && $request->filterEnd) {
                        $q = $q->whereBetween('t.deadline', [$request->filterStart, $request->filterEnd]);
                    }

                    if($request->filterStatus) {
                        $q = $q->where('t.status', $request->filterStatus);
                    }

                    if(!$request->filterStatus) {
                        $q = $q->whereNot('t.status', 'done');
                    }
                    return $q;
                })
                ->addColumn('btnStatus', function ($datatable) {
                    return view('components.elements.externals.status', [
                        'status' => $datatable->status
                    ]);
                })
                ->addColumn('action', function ($datatable) use ($exceptActions) {
                    return view('components.elements.externals.TableActionBtn', [
                        'id' => $datatable->id,
                        'route' => 'task',
                        'exceptActions' => $exceptActions
                    ]);
                })
                ->addIndexColumn()
                ->make();
        }

        # return
        return view('src.tasks.index', [
            'statuses' => $this->statuses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        # setup
        $users = DB::table('view_data_users')
            ->select('*')
            ->get();
        $clients = DB::table('clients')
            ->select('*')
            ->get();
        $projects = DB::table('projects')
            ->select('*')
            ->get();

        return view('src.tasks.formInput', [
            'title' => 'Task',
            'users' => $users,
            'clients' => $clients,
            'projects' => $projects,
            'statuses' => $this->statuses,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        # validate
        $requestValidate = $this->validator($request)->safe();
        $request->validate([
            'file_input' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        DB::beginTransaction();
        try {
            # insert
            $dataTask = $requestValidate
                ->merge(['user_id' => $request->user_id ?? auth()->user()->id])
                ->only((new Task())->fillable);
            $task = Task::create($dataTask);

            # insert file
            $filename = $request->file('file_input');
            $task->addMedia($filename)->toMediaCollection('task_media');

            # notification mail
            $descendantTask = DB::table('tasks AS t')
                ->leftJoin('view_data_users AS u', 'u.id', 't.user_id')
                ->leftJoin('clients AS c', 'c.id', 't.client_id')
                ->leftJoin('projects AS p', 'p.id', 't.project_id')
                ->select('t.*', 'c.contact_name', 'u.user_full_name AS user_name', 'p.title AS project_name', 'u.email AS email')
                ->whereNull('t.deleted_at')
                ->where('t.id', $task->id)
                ->first();

            $task->contact_name = $descendantTask->contact_name;
            $task->user_name = $descendantTask->user_name;
            $task->project_name = $descendantTask->project_name;

            # Notification
            $users = User::all();
            $data = [
                'header' => 'New Task Notification',
                'body' => "Title : $task->title",
                'link' => "/task/$task->id/edit"
            ];
            Notification::send($users, new TaskNotification($data));

            # Commit
            DB::commit();

            # response
            return redirect()->route('task.index');
        } catch (\Exception $e) {
            DB::rollBack();
            // return back()->with(['status' => $e->getMessage()]);
            return back()->with(['status' => "Task cannot be created"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        # setup
        $task = Task::findOrFail($id);
        $users = DB::table('view_data_users')
            ->select('*')
            ->get();
        $clients = DB::table('clients')
            ->select('*')
            ->get();
        $projects = DB::table('projects')
            ->select('*')
            ->get();

        return view('src.tasks.formInput', [
            'title' => 'Task',
            'task' => $task,
            'users' => $users,
            'clients' => $clients,
            'projects' => $projects,
            'statuses' => $this->statuses,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        # validate
        $requestValidate = $this->validator($request)->safe();
        $request->validate([
            'file_input' => 'nullable|image|mimes:png,jpg,jpeg'
        ]);

        # find
        $task = Task::findOrFail($id);

        DB::beginTransaction();
        try {

            # update data
            $dataTask = $requestValidate->merge(['user_id' => $request->user_id ?? auth()->user()->id])
                ->toArray();
            $task->update($dataTask);

            # update file
            $filename = $request->file('file_input');
            if ($request->hasFile('file_input')) {
                $task->addMedia($filename)->toMediaCollection('task_media');
            }

            # Commit
            DB::commit();

            # return
            return redirect()->route('task.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with(['status' => "Task cannot be updated"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        # find
        $task = Task::findOrFail($id);

        # delete
        $task->delete();

        # response
        return redirect()->route('task.index');
    }

    // /**
    //  * ==============================
    //  * Notification with Send Email
    //  * ==============================
    //  */
    // public function notification()
    // {
    //     $email = new TaskMail(['sef', 'dani']);
    //     Mail::to('sefsaham@gmail.com')->send($email);
    // }
}
