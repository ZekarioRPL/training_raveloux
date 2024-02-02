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
            'contact_name' => 'required',
            'contact_email' => 'required|email',
            'contact_phone_number' => 'required',
            'company_name' => 'required',
            'company_address' => 'required',
            'company_city' => 'required',
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
            # set column selected
            $columns = ["action"];
            if ($request->columns) {
                foreach ($request->columns as $key => $column) {
                    if ($column["name"]) {
                        $columns[] = $column["name"];
                    }
                }
            }


            # response datatable
            $clients = DB::table('clients')
                ->select('*')
                ->whereNull('deleted_at')
                ->orderBy('id', 'DESC');

            $exceptActions = ['show'];

            return DataTables::of($clients)
                ->only($columns)
                ->addIndexColumn()
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
        DB::beginTransaction();
        try {
            # validate
            $requestValidate = $this->validator($request)->safe()->toArray();

            # insert
            Client::create($requestValidate);

            # response
            return redirect()->route('client.index');
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
        DB::beginTransaction();
        try {
            # find 
            $client = Client::findOrFail($id);

            # validate
            $requestValidate = $this->validator($request)->safe()->toArray();

            # insert
            $client->update($requestValidate);

            # response
            return redirect()->route('client.index');

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
        $client = Client::findOrFail($id);

        # delete data
        $client->delete();

        # response
        return redirect()->route('client.index');
    }
}
