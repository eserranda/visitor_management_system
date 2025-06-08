<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('page.address.index');
    }

    public function findById($id)
    {
        $address = Address::with('user')->find($id);

        if (!$address) {
            return response()->json([
                'success' => false,
                'messages' => 'Data alamat tidak ditemukan'
            ], 404);
        }

        // Ambil semua user untuk dropdown
        $users = User::select('id', 'name', 'nickname')->get();

        return response()->json([
            'address' => $address,
            'users' => $users
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('page.address.create', compact('users'));
    }

    public function getAddressesGroupedByBlock()
    {
        $addresses = Address::all();

        $groupedAddresses = [];
        foreach ($addresses as $address) {
            $blockNumber = $address->block_number;

            if (!isset($groupedAddresses[$blockNumber])) {
                $groupedAddresses[$blockNumber] = [];
            }

            $groupedAddresses[$blockNumber][] = [
                'house_number' => $address->house_number,
                'user_id' => $address->user_id,
                'user_nickname' => $address->user->nickname,
                'user_status' => $address->user->status,
                'user_message' => $address->user->information,
                // 'id' => $address->id,
                // 'street_name' => $address->street_name,
            ];
        }

        return response()->json($groupedAddresses);
    }

    public function getAllDataTable()
    {
        $addresses = Address::latest('created_at')->with('user')->get();
        return datatables()->of($addresses)
            ->addIndexColumn()
            ->editColumn('user_id', function ($address) {
                if ($address->user_id == null) {
                    return '-';
                } else {
                    return $address->user->name;
                }
            })
            ->editColumn('street_name', function ($address) {
                if ($address->street_name == null) {
                    return '-';
                } else {
                    return $address->street_name;
                }
            })
            // ->editColumn('additional_info', function ($address) {
            //     if ($address->user->information != null) {
            //         return $address->user->information;
            //     } else {
            //         return '-';
            //     }
            // })

            ->addColumn('block_and_number', function ($address) {
                return  'Blok ' . $address->block_number . ' No. ' . $address->house_number;
            })
            ->addColumn('action', function ($row) {
                // cek role user
                if (auth()->user()->hasRole(['super_admin', 'penghuni'])) {
                    $btn = '<a href="#" class="btn btn-sm btn-icon btn-info me-2" onclick="edit(' . $row->id . ')"><i class="bi bi-pencil fs-4"></i></a>';
                    $btn .= '<a href="#" class="btn btn-sm btn-icon btn-danger" onclick="hapus(' . $row->id . ')"><i class="bi bi-trash"></i></a>';
                    return $btn;
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'block_number' => 'required|string',
            'house_number' => 'required|string',
        ], [
            'required' => ':attribute harus diisi',
            'unique' => ':attribute sudah ada',
            'exists' => ':attribute tidak ada',
            'string' => ':attribute harus berupa string',
            'integer' => ':attribute harus berupa angka',
        ]);


        // Tambahkan validasi kustom
        $validator->after(function ($validator) use ($request) {
            $query = Address::where('block_number', $request->block_number)
                ->where('house_number', $request->house_number)
                ->where('user_id', $request->user_id);

            // Jika dalam mode update, kecualikan record saat ini
            if (isset($address) && $address->id) {
                $query->where('id', '!=', $address->id);
            }

            if ($query->exists()) {
                $validator->errors()->add('block_number', 'Kombinasi Blok, Nomor Rumah, dan Pengguna sudah terdaftar');
            }
        });

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'messages' => $validator->errors()
            ], 422);
        }

        $save = Address::create([
            'user_id' => $request->user_id,
            'block_number' => $request->block_number,
            'house_number' => $request->house_number,
            'street_name' => $request->street_name,
        ]);

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

    /**
     * Display the specified resource.
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $address = Address::find($id);

        if (!$address) {
            return response()->json([
                'success' => false,
                'messages' => 'Data alamat tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'block_number' => 'required|string',
            'house_number' => 'required|string',
        ], [
            'required' => ':attribute harus diisi',
            'unique' => ':attribute sudah ada',
            'exists' => ':attribute tidak ada',
            'string' => ':attribute harus berupa string',
            'integer' => ':attribute harus berupa angka',
        ]);

        // Tambahkan validasi kustom
        $validator->after(function ($validator) use ($request, $address) {
            $query = Address::where('block_number', $request->block_number)
                ->where('house_number', $request->house_number)
                ->where('user_id', $request->user_id);

            // Jika dalam mode update, kecualikan record saat ini
            if (isset($address) && $address->id) {
                $query->where('id', '!=', $address->id);
            }

            if ($query->exists()) {
                $validator->errors()->add('block_number', 'Kombinasi Blok, Nomor Rumah, dan Pengguna sudah terdaftar');
            }
        });

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'messages' => $validator->errors()
            ], 422);
        }

        $address->update([
            'user_id' => $request->user_id,
            'block_number' => $request->block_number,
            'house_number' => $request->house_number,
            'street_name' => $request->street_name,
        ]);

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal diubah'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diubah'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address, $id)
    {
        $address = Address::find($id);
        $address->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
