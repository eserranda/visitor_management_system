<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();

        return view('page.users.index', compact('users'));
    }

    public function getAll()
    {
        $users = User::all();

        return response()->json($users);
    }

    public function getAllDataTable(Request $request)
    {
        $users = User::latest('created_at')->get();

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a href="#" class="btn btn-sm btn-icon btn-info me-2" onclick="edit(' . $row->id . ')"><i class="bi bi-pencil fs-4"></i></a>';
                $btn .= '<a href="#" class="btn btn-sm btn-icon btn-danger" onclick="hapus(' . $row->id . ')"><i class="bi bi-trash"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function add()
    {
        $roles = Role::all();

        return view('page.users.add', compact('roles'));
        // return view('page.users.add');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'nickname' => 'required|string|max:255',
            'phone_number' => 'required|integer',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ], [
            'required' => ':attribute harus diisi',
            'unique' => ':attribute sudah ada',
            'min' => ':attribute minimal :min karakter',
            'confirmed' => ':attribute tidak cocok',
            'exists' => ':attribute tidak ada',
            'string' => ':attribute harus berupa string',
            'integer' => ':attribute harus berupa angka',
            'email' => ':attribute harus berupa email',
            'max' => ':attribute maksimal :max karakter',
            'confirmed' => ':attribute tidak cocok',
            'roles.*' => ':attribute tidak ada',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'messages' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'nickname' => $request->nickname,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => 'in_house',
            ]);

            // dd($request->roles);

            $user->roles()->attach(Role::whereIn('id', $request->roles)->get());

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Registrasi Gagal',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Registrasi Berhasil',
            'data' => $user
        ], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'messages' => 'Berhasil menghapus data user'
        ], 200);
    }
}
