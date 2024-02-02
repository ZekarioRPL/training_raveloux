<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ManageUser extends Controller
{
    public function validator(Request $request)
    {
        $dataRequest = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'nullable',
            'phone_number' => 'required',
            'role_id' => 'required',
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
            $datatables = DB::table('view_data_users')
                ->whereNull('deleted_at')
                ->select('*')
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
        return view('src.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = DB::table('roles')
            ->whereNull('deleted_at')
            ->select('*')
            ->get();

        return view('src.users.formInput', [
            'title' => 'User',
            'roles' => $roles
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
            $requestValidate = $this->validator($request)->safe();

            # insert User
            $dataUser = $requestValidate
                ->only(['email', 'password']);
            $user = User::create($dataUser);

            $dataUserDetail = $requestValidate
                ->merge(["user_id" => $user->id])
                ->only((new UserDetail())->fillable);
            UserDetail::create($dataUserDetail);

            $dataRole = $requestValidate
                ->merge(["user_id" => $user->id])
                ->only((new UserDetail())->fillable);
            UserRole::create($dataRole);


            # return
            return redirect()->route('user.index');
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            abort(500);
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
        $roles = DB::table('roles')
            ->whereNull('deleted_at')
            ->select('*')
            ->get();
        $user = User::findOrFail($id);

        return view('src.users.formInput', [
            'title' => 'User',
            'roles' => $roles,
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // # find
        // $user = User::findOrFail($id);
        // # validate
        // $requestValidate = $this->validator($request)->safe();

        // # insert User
        // $dataUser = $requestValidate
        //     ->only((new User())->fillable);
        // $user->update($dataUser);

        // $dataUserDetail = $requestValidate
        //     ->merge(["user_id" => $user->id])
        //     ->only((new UserDetail())->fillable);
        // UserDetail::create($dataUserDetail);

        // $dataRole = $requestValidate
        //     ->merge(["user_id" => $user->id])
        //     ->only((new UserDetail())->fillable);
        // UserRole::create($dataRole);

        // # return
        // return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        # find
        $user = User::findOrFail($id);

        # delete
        $user->delete();

        # return
        return redirect()->route('user.index');
    }
}
