<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $users
       ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
        ]);      

        if ($validator->fails()){
            return response()->json([
                'status' => 'false',
                'message' => 'Validasi Error',
                'errors' => $validator->errors()
            ]);
        }

        $user = User::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dimasukkan'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $users = User::find($id);
        $status = false;
        $message = "Data tidak ditemukan";

        if ($users){
            $status = true;
            $message = "Data ditemukan";    
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
        ]);      

        if ($validator->fails()){
            return response()->json([
                'status' => 'false',
                'message' => 'Validasi Error',
                'errors' => $validator->errors()
            ]);
        }

        $user = User::find($id);
        $user->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diubah'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($data)){
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('the-token')->plainTextToken;
            return response()->json([
                'status' => true,
                'message' => 'Login Berhasil',
                'token' => $token
            ]);
        }else{
            return response()->json([
                'status' => true,
                'message' => 'Login Gagal'
            ]);
        }
    }

    public function logout(Request $request){
        Auth::logout();
 
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json([
            'success' => true,
            'message' => 'Logout Berhasil!',  
        ]);
    }
}
