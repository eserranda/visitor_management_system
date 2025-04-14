<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('page.roles.index');
    }

    public function getAllDataTable()
    {
        $roles = Role::latest('created_at')->get();

        return DataTables::of($roles)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a href="#" class="btn btn-sm btn-icon btn-info me-2" onclick="edit(' . $row->id . ')"><i class="bi bi-pencil fs-4"></i></a>';
                $btn .= '<a href="#" class="btn btn-sm btn-icon btn-danger" onclick="hapus(' . $row->id . ')"><i class="bi bi-trash"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'messages' => $validator->errors()->all()
            ], 422);
        }

        // mengubah data name agar menjadi lowercase (huruf kecil semua)
        $request->merge([
            'name' => strtolower($request->name)
        ]);

        $role = Role::create($request->all());

        return response()->json([
            'success' => true,
            'messages' => 'Role created successfully',
            'data' => $role
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role, $id)
    {
        $companies = Role::find($id);
        $companies->delete();

        return response()->json([
            'success' => true,
            'messages' => 'Berhasil menghapus data perusahaan'
        ], 200);
    }
}
