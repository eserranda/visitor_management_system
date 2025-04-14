<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function showLoginForm()
    {
        return view('page.auth.login');
    }

    public function login(Request $request)
    {
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [$loginType => $request->login, 'password' => $request->password];
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
        }


        return redirect()->back()->withErrors(['login' => 'Username or Password is incorrect'])->withInput();
    }

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

    public function findById($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'messages' => 'Data user tidak ditemukan'
            ], 404);
        }

        // ambil data user_roles
        // data roles setiap user di asumsikan hanya satu
        // jadi setiap user hanya memiliki satu role
        $user->roles = $user->roles()->first();

        // ambil data semua role
        $roles = Role::all();
        $user->all_roles = $roles;

        return response()->json($user);
    }

    public function getAllDataTable(Request $request)
    {
        $users = User::latest('created_at')->get();

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('roles', function ($row) {
                $roles = $row->roles()->pluck('name')->toArray();
                return implode(', ', $roles);
            })
            ->addColumn('status', function ($row) {
                return $row->status == 'in_house' ? 'In House' : 'Out House';
            })
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

    public function update(Request $request)
    {
        $id = $request->id;
        $validator = Validator::make($request->all(), [
            'edit_name' => 'required|string|max:255',
            'edit_username' => 'required|string|max:255|unique:users,username,' . $id,
            'edit_nickname' => 'required|string|max:255',
            'edit_phone_number' => 'required',
            'edit_email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'edit_password' => 'nullable|string|min:4|confirmed',
            'edit_roles' => 'required|array',
            'edit_roles.*' => 'exists:roles,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'messages' => $validator->errors()
            ], 422);
        }

        $update = [
            'name' => $request->edit_name,
            'username' => $request->edit_username,
            'nickname' => $request->edit_nickname,
            'phone_number' => $request->edit_phone_number,
            'email' => $request->edit_email,
            'status' => 'in_house',
        ];
        if ($request->password) {
            $update['password'] = Hash::make($request->password);
        }
        try {
            DB::beginTransaction();

            $user = User::find($id);
            $user->update($update);

            // dd($request->roles);

            $user->roles()->sync(Role::whereIn('id', $request->edit_roles)->get());

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Update Gagal',
                'error' => $e->getMessage()
            ], 500);
        }
        return response()->json([
            'success' => true,
            'message' => 'Update Berhasil',
            'data' => $user
        ], 200);
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'nickname' => 'required|string|max:255',
            'phone_number' => 'required',
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
