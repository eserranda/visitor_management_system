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
                // 'id' => $address->id,
                // 'street_name' => $address->street_name,
            ];
        }

        return response()->json($groupedAddresses);
    }

    public function getAllDataTable()
    {
        $addresses = Address::all();
        return datatables()->of($addresses)
            ->addIndexColumn()
            ->editColumn('user_id', function ($address) {
                return $address->user->nickname;
            })
            ->addColumn('block_and_number', function ($address) {
                return  'Blok ' . $address->block_number . ' No. ' . $address->house_number;
            })
            ->addColumn('action', function ($row) {
                return '<a href="#" class="btn btn-sm btn-primary">Edit</a> <a href="#" class="btn btn-sm btn-danger">Delete</a>';
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
            'street_name' => 'required|string',
        ], [
            'required' => ':attribute harus diisi',
            'unique' => ':attribute sudah ada',
            'exists' => ':attribute tidak ada',
            'string' => ':attribute harus berupa string',
            'integer' => ':attribute harus berupa angka',
        ]);

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
    public function update(Request $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        //
    }
}
