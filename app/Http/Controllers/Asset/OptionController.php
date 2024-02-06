<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OptionController extends Controller
{
    public function client(Request $request) 
    {
        // $options = 
    }

    public function usersSelect(Request $request)
    {
        $users = DB::table('view_data_users')
            ->where('user_full_name', 'like', "%$request->search%")
            ->get();
        // dd($users);

        return response()->json($users);
    }
}
