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

            # query data
            $projects = DB::table('projects AS p')
                ->leftJoin('view_data_users AS u', 'u.id', 'p.user_id')
                ->leftJoin('clients AS c', 'c.id', 'p.client_id')
                ->select('p.*', 'c.contact_name', 'u.user_full_name AS user_name')
                ->whereNull('p.deleted_at')
                ->orderBy('p.updated_at', 'DESC');

            $exceptActions = ['show'];

            return DataTables::of($projects)
                ->addIndexColumn()
                ->filter(function ($q) use ($request) {
                    if ($request->search['value']) {
                        $q = $q->where('p.title', 'LIKE', ("%" . $request->search['value'] . "%"))
                            ->orWhere('u.user_full_name', 'LIKE', ("%" . $request->search['value'] . "%"))
                            ->orWhere('c.contact_name', 'LIKE', ("%" . $request->search['value'] . "%"));
                    }

                    return $q;
                })
                ->addColumn('status', function ($project) {
                    return view('components.elements.externals.status', [
                        'status' => $project->status
                    ]);
                })
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
        # validate
        $requestValidated = $this->validator($request)->safe()->toArray();

        DB::beginTransaction();
        try {

            # insert Project
            Project::create($requestValidated);

            # Commit
            DB::commit();

            # return
            return redirect()->route('project.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with(['status' => "Client cannot be created"]);
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
        # find
        $data = Project::findOrFail($id);

        # validate
        $requestValidated = $this->validator($request)->safe()->toArray();

        DB::beginTransaction();
        try {
            # update Project
            $data->update($requestValidated);

            # Commit
            DB::commit();

            # return
            return redirect()->route('project.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with(['status' => "Project cannot be updated"]);
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
