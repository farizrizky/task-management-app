<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TaskShares;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskSharesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shared = TaskShares::all();
        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $shared
       ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_id' => 'required',
            'shared_with' => 'required',
            'permission' => 'required'
        ]);      

        if ($validator->fails()){
            return response()->json([
                'status' => 'false',
                'message' => 'Kesalahan penginputan data',
                'errors' => $validator->errors()
            ]);
        }

        $share = TaskShares::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Task berhasil dibagikan'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $shared = TaskShares::find($id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Akses Task berhasil dihapus'
        ]);
    }
}
