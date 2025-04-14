<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Models\FutureVisitor;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FutureVisitorController extends Controller
{

    public function index()
    {
        return view('page.future-visitor.index');
    }

    public function findById($id)
    {
        $futureVisitor = FutureVisitor::find($id);
        if ($futureVisitor) {
            return response()->json([
                'success' => true,
                'data' => $futureVisitor
            ]);
        } else {
            return response()->json([
                'success' => false,
                'messages' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    public function detail($id)
    {
        $futureVisitor = FutureVisitor::find($id);
        return response()->json([
            'id' => $futureVisitor->id,
            'visitor_name' => $futureVisitor->visitor_name,
            'user_id' => $futureVisitor->user ? $futureVisitor->user->nickname : '-',
            'address' => $futureVisitor->address ? 'Blok ' . $futureVisitor->address->block_number . ' No. ' . $futureVisitor->address->house_number : '-',
            'arrival_date' => Carbon::parse($futureVisitor->arrival_date)->format('d-m-Y'),
            'estimated_arrival_time' => Carbon::parse($futureVisitor->estimated_arrival_time)->format('H:i'),
            'vehicle_number' => $futureVisitor->vehicle_number,
            'vehicle_type' => $futureVisitor->vehicle_type,
            'status' => $futureVisitor->status,
            'created_at' => Carbon::parse($futureVisitor->created_at)->format('d-m-Y H:i'),
            'updated_at' => Carbon::parse($futureVisitor->updated_at)->format('d-m-Y H:i'),
        ]);
    }

    public function getAllDataTable()
    {
        $futureVisitors = FutureVisitor::latest('created_at')->get();

        return datatables()
            ->of($futureVisitors)
            ->addIndexColumn()
            ->editColumn('arrival_date', function ($futureVisitor) {
                return Carbon::parse($futureVisitor->arrival_date)->format('d-m-Y');
            })

            ->editColumn('estimated_arrival_time', function ($futureVisitor) {
                return Carbon::parse($futureVisitor->estimated_arrival_time)->format('H:i');
            })
            ->editColumn('user_id', function ($futureVisitor) {
                return $futureVisitor->user->nickname ?? '-';
            })
            ->editColumn('status', function ($futureVisitor) {
                if ($futureVisitor->status == "pending") {
                    return '<span class="badge bg-warning">Pending</span>';
                } elseif ($futureVisitor->status == "approved") {
                    return '<span class="badge bg-success">Approved</span>';
                } elseif ($futureVisitor->status == "rejected") {
                    return '<span class="badge bg-danger">Rejected</span>';
                }
                return '<span class="badge bg-secondary">Unknown</span>';
            })
            ->addColumn('address', function ($futureVisitor) {
                if ($futureVisitor->address_id) {
                    return 'Blok ' . $futureVisitor->address->block_number . ' No. ' . $futureVisitor->address->house_number;
                }
                return '-';
            })
            ->addColumn('action', function ($row) {
                if (auth()->user()->hasRole('penghuni')) {
                    $btn = '<a href="#" class="btn btn-sm btn-icon btn-info me-2" onclick="edit(' . $row->id . ')"><i class="bi bi-pencil"></i></a>';
                    $btn .= '<a href="#" class="btn btn-sm btn-icon btn-danger" onclick="hapus(' . $row->id . ')"><i class="bi bi-trash"></i></a>';
                } else if (auth()->user()->hasRole('security')) {
                    $btn = '<a href="#" class="btn btn-sm btn-icon btn-info" onclick="detail(' . $row->id . ')"><i class="bi bi-eye-fill fs-4"></i></a>';
                } else if (auth()->user()->hasRole(['admin', 'super_admin'])) {
                    $btn = '<a href="#" class="btn btn-sm btn-icon btn-info" onclick="detail(' . $row->id . ')"><i class="bi bi-eye-fill fs-4"></i></a>';
                    $btn .= '<a href="#" class="btn btn-sm btn-icon btn-success mx-2" onclick="edit(' . $row->id . ')"><i class="bi bi-pencil"></i></a>';
                    $btn .= '<a href="#" class="btn btn-sm btn-icon btn-danger" onclick="hapus(' . $row->id . ')"><i class="bi bi-trash"></i></a>';
                }
                return $btn;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'visitor_name' => 'required|string|max:255',
            'arrival_date' => 'required|date',
            'estimated_arrival_time' => 'required|date_format:H:i',
            'vehicle_number' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'messages' => $validator->errors()->all()
            ], 422);
        }

        // cek apakah user memiliki role penghuni
        if (Auth::user()->hasRole('penghuni')) {
            $user_id = Auth::user()->id;
            $address_id = Address::where('user_id', $user_id)->first()->id;
            $futureVisitor = FutureVisitor::create([
                'user_id' => $user_id,
                'address_id' => $address_id,
                'visitor_name' => $request->visitor_name,
                'arrival_date' => $request->arrival_date,
                'estimated_arrival_time' => $request->estimated_arrival_time,
                'vehicle_number' => $request->vehicle_number,
                'vehicle_type' => $request->vehicle_type,
            ]);

            if ($futureVisitor) {
                return response()->json([
                    'success' => true,
                    'messages' => 'Data berhasil ditambahkan'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'messages' => 'Data gagal ditambahkan'
                ], 500);
            }
        } else {
            return response()->json([
                'success' => false,
                'messages' => 'Anda tidak memiliki akses untuk menambahkan data ini'
            ], 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FutureVisitor $futureVisitor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FutureVisitor $futureVisitor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FutureVisitor $futureVisitor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FutureVisitor $futureVisitor)
    {
        //
    }
}
