<?php

namespace App\Http\Controllers\Spatie;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageMediaLibrary extends Controller
{
    //

    /**
     * DESTROY
     */
    public function destroy(string $id)
    {
        try {
            DB::table('media')
                ->where('id', $id)
                ->delete();

            return back()->with(['status' => 'Image Telah Terhapus']);
        } catch (Exception $e) {
            return back()->with(['status' => $e]);
        }
    }
}
