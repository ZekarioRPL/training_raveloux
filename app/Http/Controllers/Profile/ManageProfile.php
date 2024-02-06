<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ManageProfile extends Controller
{
    public function validator(Request $request)
    {
        $dataRequest = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'nullable',
            'phone_number' => 'required',
        ]);

        if ($dataRequest->fails()) {
            abort(back()->withErrors($dataRequest)->withInput());
        }

        return $dataRequest;
    }


    public function edit(string $id)
    {
        $userRole = User::findOrFail($id);
        $profile = DB::table('view_data_users')
            ->where('id', $id)
            ->first();
        return view('src.profile.editProfile', [
            'profile' => $profile,
            'userRole' => $userRole
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        # validate
        $request->validate([
            'email' => 'required|email',
            'password' => 'nullable',
            'file_input' => 'nullable|image|mimes:png,jpg,jpeg'
        ]);

        $requestValidate = $this->validator($request)->safe();

        DB::beginTransaction();
        try {
            # find
            $user = User::findOrFail($id);

            # User
            $dataUser = ['email' => $request->email];
            if ($request->password) {
                $dataUser['password'] = $request->password;
            }
            $user->update($dataUser);

            # User Detail
            $userDetail = UserDetail::where('user_id', $user->id)->first();
            $dataUserDetail = $requestValidate
                ->merge(["user_id" => $user->id])
                ->only((new UserDetail())->fillable);
            $userDetail->update($dataUserDetail);

            # image
            $filename = $request->file('file_input');
            if ($request->hasFile('file_input')) {
                $user->addMedia($filename)->toMediaCollection('user_media');
            }

            # Commit
            DB::commit();

            # return
            return redirect()->route('user.index');
        } catch (\Exception $e) {
            DB::rollBack();
            // return back()->with(['status' => "Don't Can Edit Profile"]);
            return back()->with(['status' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
