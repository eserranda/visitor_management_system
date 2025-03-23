<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $users = User::all();

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
        // $roles = Role::all();

        // return view('page.users.add', compact('roles'));
        return view('page.users.add');
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
            // 'roles' => 'required|array',
            // 'roles.*' => 'exists:roles,name',
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
            // 'roles.*' => ':attribute tidak ada',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'messages' => $validator->errors()
            ], 422);
        }

        $save = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'nickname' => $request->nickname,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'in_house',
        ]);

        // $user->roles()->attach(Role::whereIn('name', $request->roles)->get());
        if (!$save) {
            return response()->json([
                'success' => false,
                'message' => 'Registrasi Gagal'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Registrasi Berhasil'
        ], 200);
    }
}
