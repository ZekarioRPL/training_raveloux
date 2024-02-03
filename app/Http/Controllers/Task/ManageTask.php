<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ManageTask extends Controller
{
    public function validator($request)
    {
        $dataRequest = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'nullable',
            'deadline' => 'required|date',
            'user_id' => 'required|integer',
            'client_id' => 'required|integer',
            'project_id' => 'required|integer',
            'status' => 'required',
        ]);

        if ($dataRequest->fails()) {
            abort(back()->withErrors($dataRequest)->withInput());
        }

        return $dataRequest;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            # set column selected
            $columns = ["action"];
            if ($request->columns) {
                foreach ($request->columns as $key => $column) {
                    if ($column["name"]) {
                        $columns[] = $column["name"];
                    }
                }
            }

            # query data
            $datatables = DB::table('tasks AS t')
                ->leftJoin('view_data_users AS u', 'u.id', 't.user_id')
                ->leftJoin('clients AS c', 'c.id', 't.client_id')
                ->leftJoin('projects AS p', 'p.id', 't.project_id')
                ->select('t.*', 'c.contact_name', 'u.user_full_name AS user_name', 'p.title AS project_name')
                ->whereNull('t.deleted_at')
                ->orderBy('id', 'DESC');

            $exceptActions = ['show'];

            return DataTables::of($datatables)
                ->only($columns)
                ->addIndexColumn()
                ->addColumn('action', function ($datatable) use ($exceptActions) {
                    return view('components.elements.externals.TableActionBtn', [
                        'id' => $datatable->id,
                        'route' => 'task',
                        'exceptActions' => $exceptActions
                    ]);
                })
                ->make();
        }

        # return
        return view('src.tasks.index');
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
        $statuses = ['open', 'on', 'off'];

        return view('src.tasks.formInput', [
            'title' => 'Task',
            'users' => $users,
            'clients' => $clients,
            'projects' => $projects,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        # validate
        $requestValidate = $this->validator($request)->safe()->toArray();

        // DB::beginTransaction();
        // try {

        # insert
        Task::create($requestValidate);

        # response
        return redirect()->route('task.index');

        //     DB::commit();
        // } catch (\Throwable $e) {
        //     DB::rollBack();
        //     return abort(500);
        // }
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
        $statuses = ['open', 'on', 'off'];

        return view('src.tasks.formInput', [
            'title' => 'Task',
            'task' => $task,
            'users' => $users,
            'clients' => $clients,
            'projects' => $projects,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        # validate
        $requestValidate = $this->validator($request)->safe()->toArray();

        // DB::beginTransaction();
        // try {
        # find
        $task = Task::findOrFail($id);

        # insert
        $task->update($requestValidate);

        # response
        return redirect()->route('task.index');

        //     DB::commit();
        // } catch (\Throwable $e) {
        //     DB::rollBack();
        //     return abort(500);
        // }
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
}
