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


    public function updateStatus(Request $request, $id)
    {
        // format $id ke integer
        $id = (int)$id;
        // gunakan Carbon untuk mendapatkan waktu saat berdasarkan timezone
        // $timeNow = Carbon::now('Asia/Makassar');
        // dd($timeNow);
        $futureVisitor = FutureVisitor::find($id);
        if ($futureVisitor) {
            $futureVisitor->status = $request->status;
            $futureVisitor->check_in = Carbon::now('Asia/Makassar');
            $futureVisitor->save();

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }


    public function findById($id)
    {
        $futureVisitor = FutureVisitor::find($id);
        if ($futureVisitor) {
            return response()->json([
                'success' => true,
                'data' => $futureVisitor
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    public function detail($id)
    {
        $futureVisitor = FutureVisitor::find($id);

        $checkIn = Carbon::parse($futureVisitor->check_in)->format('d-m-Y H:i T');
        return response()->json([
            'id' => $futureVisitor->id,
            'visitor_name' => $futureVisitor->visitor_name,
            'user_id' => $futureVisitor->user ? $futureVisitor->user->nickname : '-',
            'address' => $futureVisitor->address ? 'Blok ' . $futureVisitor->address->block_number . ' No. ' . $futureVisitor->address->house_number : '-',
            'arrival_date' => Carbon::parse($futureVisitor->arrival_date)->format('d-m-Y'),
            'estimated_arrival_time' => Carbon::parse($futureVisitor->estimated_arrival_time)->setTimezone('Asia/Makassar')->format('H:i T'),
            'vehicle_number' => $futureVisitor->vehicle_number,
            'vehicle_type' => $futureVisitor->vehicle_type,
            'status' => $futureVisitor->status ? $futureVisitor->status : '-',
            'check_in' => $futureVisitor->check_in ? Carbon::parse($futureVisitor->check_in)->setTimezone('Asia/Makassar')->format('d-m-Y H:i T') : '-',
            'check_out' => $futureVisitor->check_out ? Carbon::parse($futureVisitor->check_out)->format('d-m-Y H:i') : '-',
            'created_at' => Carbon::parse($futureVisitor->created_at)->format('d-m-Y H:i'),
            'updated_at' => Carbon::parse($futureVisitor->updated_at)->format('d-m-Y H:i'),
            'img_url' => $futureVisitor->img_url,
        ]);
    }

    public function getAllDataTable(Request $request)
    {
        $filter = $request->query('filter');

        // jika user yang login adalah security, admin, atau super_admin maka tampilkan semua data
        $user = Auth::user();
        if ($user->hasRole(['security', 'admin', 'super_admin'])) {
            $futureVisitors = FutureVisitor::latest('created_at')->get();
        } else {
            $user_id = Auth::user()->id;
            if ($filter) {
                if ($filter == 'pending') {
                    $futureVisitors =  FutureVisitor::where('user_id', $user_id)->where('status', 'pending')->latest('created_at')->get();
                } else if ($filter == 'approved') {
                    $futureVisitors =  FutureVisitor::where('user_id', $user_id)->where('status', 'approved')->latest('created_at')->get();
                } else if ($filter == 'rejected') {
                    $futureVisitors =  FutureVisitor::where('user_id', $user_id)->where('status', 'rejected')->latest('created_at')->get();
                } else if ($filter == 'canceled') {
                    $futureVisitors =  FutureVisitor::where('user_id', $user_id)->where('status', 'canceled')->latest('created_at')->get();
                }
            } else {
                $futureVisitors = FutureVisitor::where('user_id', $user_id)->latest('created_at')->get();
            }
        }

        return datatables()
            ->of($futureVisitors)
            ->addIndexColumn()
            ->editColumn('estimated_arrival_time', function ($futureVisitor) {
                return Carbon::parse($futureVisitor->arrival_date)->format('d-m-Y') . ' ' . Carbon::parse($futureVisitor->estimated_arrival_time)->format('H:i') . ' WITA';
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
                    $btn = '<a href="#" class="btn btn-sm btn-icon btn-info" onclick="detail(' . $row->id . ')"><i class="bi bi-eye-fill fs-4"></i></a>';
                    $btn .= '<a href="#" class="btn btn-sm btn-icon btn-success mx-2" onclick="edit(' . $row->id . ')"><i class="bi bi-pencil"></i></a>';
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

    public function visitorRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'visitor_name' => 'required|string|max:255',
            'arrival_date' => 'required|date',
            'estimated_arrival_time' => 'required|date_format:H:i',
            'vehicle_number' => 'nullable|string|max:255',
            'captured_image' => 'required|file|mimes:jpeg,png,jpg|max:5048',
        ], [
            'user_id.required' => 'Penghuni harus dipilih',
            'visitor_name.required' => 'Nama pengunjung harus diisi',
            'arrival_date.required' => 'Tanggal kedatangan harus diisi',
            'arrival_date.date' => 'Format tanggal kedatangan tidak valid',
            'estimated_arrival_time.required' => 'Perkiraan waktu kedatangan harus diisi',
            'estimated_arrival_time.date_format' => 'Format perkiraan waktu kedatangan tidak valid',
            'vehicle_number.string' => 'Nomor kendaraan tidak valid',
            'vehicle_number.max' => 'Nomor kendaraan maksimal 255 karakter',
            'captured_image.required' => 'Gambar harus diunggah',
            'captured_image.file' => 'File tidak valid',
            'captured_image.mimes' => 'Hanya file JPEG, PNG, JPG yang diperbolehkan',
            'captured_image.max' => 'Ukuran file maksimal 5MB'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'messages' => $validator->errors()
            ], 422);
        }

        $photoPath = null;
        if ($request->file('captured_image')) {
            $image = $request->file('captured_image');

            $directory = 'images/future_visitor/';
            $imageName = 'future_visitor_' . time() . '.' . $image->getClientOriginalExtension();

            // pindahkan file ke direktori yang diinginkan
            $image->move(public_path($directory), $imageName);

            // 'images/future_visitor/namafile.jpg'
            $photoPath = $directory . $imageName;
        }

        // cek apakah user memiliki role penghuni

        $user_id = $request->user_id;
        $address_id = Address::where('user_id', $user_id)->first()->id;
        $futureVisitor = FutureVisitor::create([
            'user_id' => $user_id,
            'address_id' => $address_id,
            'visitor_name' => $request->visitor_name,
            'arrival_date' => $request->arrival_date,
            'estimated_arrival_time' => $request->estimated_arrival_time,
            'vehicle_number' => $request->vehicle_number,
            'vehicle_type' => $request->vehicle_type,
            'img_url' => $photoPath,
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
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'visitor_name' => 'required|string|max:255',
            'arrival_date' => 'required|date',
            'estimated_arrival_time' => 'required|date_format:H:i',
            'vehicle_number' => 'nullable|string|max:255',
            'captured_image' => 'required|file|mimes:jpeg,png,jpg|max:5048',
        ], [
            'visitor_name.required' => 'Nama pengunjung harus diisi',
            'arrival_date.required' => 'Tanggal kedatangan harus diisi',
            'arrival_date.date' => 'Format tanggal kedatangan tidak valid',
            'estimated_arrival_time.required' => 'Perkiraan waktu kedatangan harus diisi',
            'estimated_arrival_time.date_format' => 'Format perkiraan waktu kedatangan tidak valid',
            'vehicle_number.string' => 'Nomor kendaraan tidak valid',
            'vehicle_number.max' => 'Nomor kendaraan maksimal 255 karakter',
            'captured_image.required' => 'Gambar harus diunggah',
            'captured_image.file' => 'File tidak valid',
            'captured_image.mimes' => 'Hanya file JPEG, PNG, JPG yang diperbolehkan',
            'captured_image.max' => 'Ukuran file maksimal 5MB'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'messages' => $validator->errors()
            ], 422);
        }

        $photoPath = null;
        if ($request->file('captured_image')) {
            $image = $request->file('captured_image');

            $directory = 'images/future_visitor/';
            $imageName = 'future_visitor_' . time() . '.' . $image->getClientOriginalExtension();

            // pindahkan file ke direktori yang diinginkan
            $image->move(public_path($directory), $imageName);

            // 'images/future_visitor/namafile.jpg'
            $photoPath = $directory . $imageName;
        }

        // cek apakah user memiliki role penghuni
        if (Auth::user()->hasRole(['penghuni', 'admin', 'super_admin'])) {
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
                'img_url' => $photoPath,
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
     * Remove the specified resource from storage.
     */
    public function destroy(FutureVisitor $futureVisitors, $id)
    {
        $futureVisitor = $futureVisitors::find($id);
        // hapus file gambar
        $img_url = $futureVisitor->img_url;
        if ($img_url) {
            $filePath = public_path($img_url);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $futureVisitor->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
