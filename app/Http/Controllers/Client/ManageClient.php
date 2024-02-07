<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ManageClient extends Controller
{

    public function validator($request)
    {
        $dataRequest = Validator::make($request->all(), [
            'contact_name' => 'required|string',
            'contact_email' => 'nullable|email',
            'contact_phone_number' => 'required',
            'company_name' => 'required|string',
            'company_address' => 'required',
            'company_city' => 'required|string',
            'company_zip' => 'nullable',
            'company_val' => 'nullable',
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
            # response datatable
            $clients = DB::table('clients AS c')
                ->leftJoin('view_data_users AS u', 'u.id', 'c.user_id')
                ->select('c.*', 'u.user_full_name AS user_name')
                ->whereNull('c.deleted_at')
                ->when(auth()->user()->hasRole('simple'), function ($q) {
                    return $q->where('c.user_id', auth()->user()->id);
                })
                ->orderBy('c.updated_at', 'DESC');

            $exceptActions = ['show'];

            return DataTables::of($clients)
                ->addIndexColumn()
                ->filter(function ($q) use ($request) {
                    if ($request->search['value']) {
                        $q = $q->where('company_name', 'LIKE', ("%" . $request->search['value'] . "%"));
                    }

                    return $q;
                })
                ->addColumn('action', function ($client) use ($exceptActions) {
                    return view('components.elements.externals.TableActionBtn', [
                        'id' => $client->id,
                        'route' => 'client',
                        'exceptActions' => $exceptActions
                    ]);
                })
                ->make();
        }

        # return
        return view('src.client.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('src.client.formInput', [
            'title' => 'client'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        # validate
        $requestValidate = $this->validator($request)->safe();

        DB::beginTransaction();
        try {
            # insert
            $dataClient = $requestValidate->merge(['user_id' => auth()->user()->id]);
            Client::create($dataClient);

            # Commit
            DB::commit();

            # response
            return redirect()->route('client.index');
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
        $client = DB::table('clients')
            ->where('id', $id)
            ->first();

        return view('src.client.formInput', [
            'client' => $client,
            'title' => 'client'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        # find 
        $client = Client::findOrFail($id);

        # validate
        $requestValidate = $this->validator($request)->safe();

        DB::beginTransaction();
        try {
            # update
            $dataClient = $requestValidate->merge(['user_id' => auth()->user()->id]);
            $client->update($dataClient);

            # Commit
            DB::commit();

            # return
            return redirect()->route('client.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with(['status' => "Client cannot be updated"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        # find 
        $client = Client::findOrFail($id);

        # delete data
        $client->delete();

        # response
        return redirect()->route('client.index');
    }
}
