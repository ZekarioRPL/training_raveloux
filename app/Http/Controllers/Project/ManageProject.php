<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ManageProject extends Controller
{
    public function validator($request)
    {
        $dataRequest = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'nullable',
            'deadline' => 'required|date',
            'user_id' => 'required|integer',
            'client_id' => 'required|integer',
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
            $projects = DB::table('projects AS p')
                ->leftJoin('view_data_users AS u', 'u.id', 'p.user_id')
                ->leftJoin('clients AS c', 'c.id', 'p.client_id')
                ->select('p.*', 'c.contact_name', 'u.user_full_name AS user_name')
                ->whereNull('p.deleted_at')
                ->orderBy('id', 'DESC');

            $exceptActions = ['show'];

            return DataTables::of($projects)
                ->only($columns)
                ->addIndexColumn()
                ->addColumn('action', function ($project) use ($exceptActions) {
                    return view('components.elements.externals.TableActionBtn', [
                        'id' => $project->id,
                        'route' => 'project',
                        'exceptActions' => $exceptActions
                    ]);
                })
                ->make();
        }

        # return
        return view('src.projects.index');
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
        $statuses = ['open', 'on', 'off'];

        # return
        return view('src.projects.formInput', [
            'title' => 'Project',
            'users' => $users,
            'clients' => $clients,
            'statuses' => $statuses
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            # validate
            $requestValidated = $this->validator($request)->safe()->toArray();

            # insert Project
            Project::create($requestValidated);

            # return
            return redirect()->route('project.index');

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return abort(500);
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
        $project = Project::findOrFail($id);
        $users = DB::table('view_data_users')
            ->select('*')
            ->get();
        $clients = DB::table('clients')
            ->select('*')
            ->get();
        $statuses = ['open', 'on', 'off'];

        # return
        return view('src.projects.formInput', [
            'title' => 'Project',
            'project' => $project,
            'users' => $users,
            'clients' => $clients,
            'statuses' => $statuses
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            # find
            $data = Project::findOrFail($id);

            # validate
            $requestValidated = $this->validator($request)->safe()->toArray();

            # insert Project
            $data->update($requestValidated);

            # return
            return redirect()->route('project.index');

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return abort(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        # find
        $data = Project::findOrFail($id);

        # delete
        $data->delete();

        # return
        return redirect()->route('project.index');
    }
}
