<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Visitors;
use App\Models\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class VisitorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transportasi_onlie = Companies::where('type', 'transportasi_online')->get();
        $companies = Companies::all();
        return view('page.visitors.index', compact('companies', 'transportasi_onlie'));
    }

    public function pengunjungAktif()
    {
        $transportasi_onlie = Companies::where('type', 'transportasi_online')->get();
        $companies = Companies::all();
        return view('page.visitors.pengunjung_aktif', compact('companies', 'transportasi_onlie'));
    }

    public function registrasi()
    {
        $transportasi_onlie = Companies::where('type', 'transportasi_online')->get();
        $companies = Companies::all();
        return view('page.visitors.registrasi', compact('companies', 'transportasi_onlie'));
    }

    public function GetAllDataPengunjungAktif()
    {
        $visitors = Visitors::where('status', 'visiting')
            ->latest('created_at')
            ->get();
        return DataTables::of($visitors)
            ->addIndexColumn()
            ->editColumn('user_id', function ($row) {
                return $row->user->nickname;
            })
            ->editColumn('visitor_type', function ($row) {
                if ($row->visitor_type == 'kurir') {
                    return 'Kurir' . ' (' . $row->company->name . ')';
                } else if ($row->visitor_type == 'transportasi_online') {
                    return 'Trans. Online' . ' (' . $row->company->name . ')';
                } else {
                    return 'Tamu Pribadi';
                }
            })
            ->editColumn('check_in', function ($row) {
                return Carbon::parse($row->check_in)->format('d-m-Y H:i:s');
            })
            ->editColumn('check_out', function ($row) {
                return  $row->check_out ? Carbon::parse($row->check_out)->format('d-m-Y H:i:s') : '-';
            })
            ->editColumn('status', function ($row) {
                if ($row->status == 'visiting') {
                    return '<span class="badge badge-warning">Sedang Berkunjung</span>';
                } else {
                    return 'Sudah Check Out';
                }
            })
            // ->editColumn('img_url', function ($row) {
            //     return '<img src="' . asset($row->img_url) . '" alt="visitor" width="100" height="100">';
            // })

            ->addColumn('action', function ($row) {
                $btn = '<a href="#" class="btn btn-sm btn-icon btn-success me-2" onclick="updateStatus(' . $row->id . ', \'completed\')"><i class="bi bi-check2-circle fs-4"></i></a>';
                $btn .= '<a href="#" class="btn btn-sm btn-icon btn-info" onclick="detail(' . $row->id  . ')"><i class="bi bi-eye fs-4"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function getAllWithDataTable(Request $request)
    {
        // cek apakah ada query search
        $filter = $request->query('filter');

        if ($filter) {
            // jika query search adalah weekly, maka ambil data pengunjung yang check in pada minggu ini
            if ($filter == 'weekly') {
                $visitors = Visitors::where('check_in', '>=', Carbon::now()->startOfWeek())
                    ->where('check_in', '<=', Carbon::now()->endOfWeek())
                    ->latest('created_at')
                    ->get();
            } else {
                // jika query search adalah monthly, maka ambil data pengunjung yang check in pada bulan ini
                $visitors = Visitors::where('check_in', '>=', Carbon::now()->startOfMonth())
                    ->where('check_in', '<=', Carbon::now()->endOfMonth())
                    ->latest('created_at')
                    ->get();
            }
        } else {
            // jika tidak ada query search, maka ambil semua data pengunjung
            $visitors = Visitors::where('status', 'completed')->latest('created_at')->get();
        }

        return DataTables::of($visitors)
            ->addIndexColumn()
            ->editColumn('user_id', function ($row) {
                return $row->user->nickname;
            })
            ->editColumn('visitor_type', function ($row) {
                $companyName = $row->company ? $row->company->name : ' - ';
                if ($row->visitor_type == 'kurir') {
                    return 'Kurir' . ' (' . $companyName . ')';
                } else if ($row->visitor_type == 'transportasi_online') {
                    return 'Trans. Online' . ' (' . $companyName . ')';
                } else {
                    return 'Tamu Pribadi';
                }
            })
            ->editColumn('check_in', function ($row) {
                return Carbon::parse($row->check_in)->format('d-m-Y H:i:s');
            })
            ->editColumn('check_out', function ($row) {
                return Carbon::parse($row->check_out)->format('d-m-Y H:i:s');
            })
            ->editColumn('status', function ($row) {
                if ($row->status == 'visiting') {
                    return '<span class="badge badge-warning">Sedang Berkunjung</span>';
                } else {
                    return 'Sudah Check Out';
                }
            })
            // ->editColumn('img_url', function ($row) {
            //     return '<img src="' . asset($row->img_url) . '" alt="visitor" width="100" height="100">';
            // })

            ->addColumn('action', function ($row) {
                $btn = '<a href="#" class="btn btn-sm btn-icon btn-info me-2" onclick="detail(' . $row->id  . ')"><i class="bi bi-eye fs-4"></i></a>';
                $btn .= '<a href="#" class="btn btn-sm btn-icon btn-danger" onclick="hapus(' . $row->id . ')"><i class="bi bi-trash"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'user_id' => 'required|integer|exists:users,id',
            'captured_image' => 'required|string',
            'phone_number' => 'required|string',
            'visitor_type' => 'required|string',
            'purpose' => 'required|string',
        ], [
            'required' => ':attribute harus diisi',
            'string' => ':attribute harus berupa string',
            'integer' => ':attribute harus berupa angka',
            'exists' => ':attribute tidak ada',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'messages' => $validator->errors()
            ], 422);
        }

        $photoPath = null;
        if ($request->input('captured_image')) {
            $imageData = $request->input('captured_image');
            $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
            $imageData = str_replace(' ', '+', $imageData);

            $imageName = 'visitor_' . time() . '.jpg';

            // Direktori relatif dari folder 'storage/app/public'
            $directory = 'images/visitor/';

            // Pastikan folder ada
            if (!file_exists(public_path($directory))) {
                mkdir(public_path($directory), 0755, true);
            }

            // Simpan file ke public/images/visitor/
            file_put_contents(public_path($directory . $imageName), base64_decode($imageData));

            // Path untuk database (contoh: 'images/visitor/visitor_123456.jpg')
            $photoPath = $directory . $imageName;
        }

        // Simpan data ke database
        $visitor = Visitors::create([
            'name' => $request->input('name'),
            'user_id' => $request->input('user_id'),
            'visitor_type' => $request->input('visitor_type'),
            'company_id' => $request->input('company_id'),
            'phone_number' => $request->input('phone_number'),
            'vehicle_number' => $request->input('vehicle_number'),
            'purpose' => $request->input('purpose'),
            'check_in' => Carbon::now(),
            'status' => 'visiting',
            'img_url' => $photoPath,
        ]);

        $security_name = auth()->user()->nickname;
        $user = User::find($request->user_id);
        $company = Companies::find($request->company_id);

        $companyName = $company ? $company->name : ' - ';

        // $apiUri = env('API_URL');
        $uri = env('API_URL') . '/send-notification/guest';

        try {
            Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($uri, [
                'user_phone_number' => $user->phone_number,
                'user_name' => $user->nickname,
                'security_name' => $security_name,
                // Bodoata pengunjung
                'visitor_name' => $request->name,
                'visitor_type' => $request->visitor_type,
                'company_name' => $companyName,
                'vehicle_number' => $request->vehicle_number,
                'purpose' => $request->purpose,
                'check_in' =>   Carbon::now()->format('d-m-Y H:i T'),
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal kirim notifikasi: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim notifikasi ke pengunjung' . $e->getMessage()
            ], 500);
        }


        if (!$visitor) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data pengunjung'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan data pengunjung'
        ], 200);
    }

    public function detail($id)
    {
        $visitor = Visitors::findOrFail($id);
        return response()->json([
            'id' => $visitor->id,
            'name' => $visitor->name,
            'purpose' => $visitor->purpose,
            'phone_number' => $visitor->phone_number,
            'vehicle_number' => $visitor->vehicle_number,
            'visitor_type' => $visitor->visitor_type,
            'company_id' => $visitor->company_id ? $visitor->company->name : '-',
            'check_in' => Carbon::parse($visitor->check_in)->format('d-m-Y H:i:s'),
            'check_out' => $visitor->check_out ? Carbon::parse($visitor->check_out)->format('d-m-Y H:i:s') : '-',
            'status' => $visitor->status,
            'img_url' => $visitor->img_url,
        ]);
    }

    public function update(Request $request, $id)
    {
        $visitor = Visitors::find($id);
        $visitor->check_out = Carbon::now();
        $visitor->status = $request->status;
        $visitor->save();

        if (!$visitor) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status pengunjung'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengubah status pengunjung'
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visitors $visitors, $id)
    {
        $visitor = $visitors::find($id);

        $img_url = $visitor->img_url;
        if ($img_url) {
            $filePath = public_path($img_url);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $visitor->delete();

        if (!$visitor) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data pengunjung'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus data pengunjung'
        ], 200);
    }
}
