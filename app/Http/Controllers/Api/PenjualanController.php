<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PenjualanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class PenjualanController extends Controller
{
    public function __invoke(Request $request)
    {
        // remove token
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

        if ($removeToken) {
            // return response JSON
            return response()->json([
                'success' => true,
                'message' => 'Logout Berhasil!',
            ]);
        }
    }

    public function index()
    {
        return PenjualanModel::all();
    }

    public function store(Request $request)
    {
        $rules = [
            'user_id' => 'required|integer',
            'pembeli' => 'required|string|max:100',
            'penjualan_kode' => 'required|string|min:3|unique:t_penjualan,penjualan_kode',
            'penjualan_tanggal' => 'required|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $image = $request->file('image');
        $image->storeAs('penjualan', $image->hashName(), 'public');

        $penjualan = PenjualanModel::create([
            'user_id' => $request->user_id,
            'pembeli' => $request->pembeli,
            'penjualan_kode' => $request->penjualan_kode,
            'penjualan_tanggal' => $request->penjualan_tanggal,
            'image' => $image->hashName(),
        ]);

        return response()->json($penjualan, 201);
    }

    public function show(PenjualanModel $penjualan)
    {
        return response()->json($penjualan);
    }

    public function update(Request $request, PenjualanModel $penjualan)
    {
        $rules = [
            'user_id' => 'required|integer',
            'pembeli' => 'required|string|max:100',
            'penjualan_kode' => 'required|string|min:3|max:10|unique:t_penjualan,penjualan_kode,' . $penjualan->penjualan_id . ',penjualan_id',
            'penjualan_tanggal' => 'required|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($penjualan) {
            $oldImage = 'penjualan/' . $penjualan->image;
            if (Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }

            $image = $request->file('image');
            $image->storeAs('penjualan', $image->hashName(), 'public');

            $penjualan->update([
                'user_id' => $request->user_id,
                'pembeli' => $request->pembeli,
                'penjualan_kode' => $request->penjualan_kode,
                'penjualan_tanggal' => $request->penjualan_tanggal,
                'image' => $image->hashName(),
            ]);

            return response()->json($penjualan);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    public function destroy(PenjualanModel $penjualan)
    {
        if ($penjualan) {
            $oldImage = 'penjualan/' . $penjualan->image;
            if (Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }

            $penjualan->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data terhapus',
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Data tidak ditemukan'
        ], 404);
    }
}
