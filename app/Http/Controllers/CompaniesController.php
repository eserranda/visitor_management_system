<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('page.companies.index');
    }

    public function getAllDataTable(Request $request)
    {
        $companies = Companies::latest('created_at')->get();

        return DataTables::of($companies)
            ->addIndexColumn()
            ->editColumn('type', function ($row) {
                return $row->type == 'transportasi_online' ? 'Transportasi Online' : '-';
            })
            ->editColumn('phone_number', function ($row) {
                return $row->phone_number ?? '-';
            })
            ->editColumn('address', function ($row) {
                return $row->address ?? '-';
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="#" class="btn btn-sm btn-icon btn-info me-2" onclick="updateStatus(' . $row->id . ')"><i class="bi bi-pencil fs-4"></i></a>';
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
        ], [
            'required' => ':attribute harus diisi',
            'string' => ':attribute harus berupa string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'messages' => $validator->errors()
            ], 422);
        }

        $companies = Companies::create([
            'name' => $request->name,
            'type' => $request->type,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        if (!$companies) {
            return response()->json([
                'success' => false,
                'messages' => 'Gagal menambahkan data perusahaan'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'messages' => 'Berhasil menambahkan data perusahaan'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Companies $companies)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Companies $companies)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Companies $companies)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Companies $companies, $id)
    {
        $companies = Companies::find($id);

        if (!$companies) {
            return response()->json([
                'success' => false,
                'messages' => 'Data perusahaan tidak ditemukan'
            ], 404);
        }

        $companies->delete();

        return response()->json([
            'success' => true,
            'messages' => 'Berhasil menghapus data perusahaan'
        ], 200);
    }
}
