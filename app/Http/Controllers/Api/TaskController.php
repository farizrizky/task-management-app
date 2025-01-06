<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tasks;
use Illuminate\Console\View\Components\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Tasks::all();
        return response()->json([
            'status' => true,
            'data' => $tasks
       ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'deadline' => 'required|date_format:Y-m-d H:i:s',
            'label' => 'required'
        ]);      

        if ($validator->fails()){
            return response()->json([
                'status' => 'false',
                'message' => 'Kesalahan penginputan data',
                'errors' => $validator->errors()
            ]);
        }

        $request->merge(["created_by"=>Auth::id()]);
        $label = explode(',', $request['label']);
        $request['label'] = json_encode($label); 
        $tasks = Tasks::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Task berhasil ditambahkan'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tasks = Tasks::find($id);
        $status = false;
        $message = "Data tidak ditemukan";

        if ($tasks){
            $status = true;
            $message = "Data ditemukan";    
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $tasks
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'deadline' => 'required|date_format:Y-m-d H:i:s',
            'label' => 'required'
        ]);      

        if ($validator->fails()){
            return response()->json([
                'status' => 'false',
                'message' => 'Kesalahan penginputan data',
                'errors' => $validator->errors()
            ]);
        }

        $task = Tasks::find($id);
        $label = explode(',', $request['label']);
        $request['label'] = json_encode($label); 
        $task->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Task berhasil diubah'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Tasks::find($id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Task berhasil dihapus'
        ]);
    }

    // public function getTasks(Request $request){
    //     $params = $request->all();
    //     $task = Tasks::where($params)->all();
    //     return response()->json([
    //         'status' => true,
    //         'data' => $task
    //     ]);

    // }
}
