<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\LevelModel;
use App\Models\StokBarangModel;
use App\Models\StokModel;
use App\Models\User;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Livewire\Features\SupportModels\SupportModels;
use PhpOffice\PhpSpreadsheet\IOFactory;

class StokBarangController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Stok Barang',
            'list' => ['Home', 'Stok Barang']
        ];
        $page = (object) [
            'title' => 'Daftar Stok Barang yang terdaftar dalam sistem'
        ];
        $activeMenu = 'StokBarang'; // set menu yang sedang aktif

        $supplier = StokModel::all(); // ambil data level untuk filter level

        return view('StokBarang.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'supplier' => $supplier, 'activeMenu' => $activeMenu]);
    }

    // tambahan
    public function tambah()
    {
        return view('stokBarang_tambah');
    }

    public function tambah_simpan(Request $request)
    {
        StokBarangModel::create([
            'supplier_id' => $request->supplier_id,
            'barang_id' => $request->barang_id,
            'user_id' => $request->user_id,
            'stok_tanggal' => $request->stok_tanggal,
            'stok_jumlah' => $request->stok_jumlah
        ]);
        return redirect('/StokBarang');
    }

    public function ubah($stok_id)
    {
        $stokBarang = StokBarangModel::find($stok_id);
        return view('stokBarang_ubah', ['data' => $stokBarang]);
    }

    public function ubah_simpan($stok_id, Request $request)
    {
        $stokBarang = StokBarangModel::find($stok_id);
        $stokBarang->supplier_id = $request->supplier_id;
        $stokBarang->barang_id = $request->barang_id;
        $stokBarang->user_id = $request->user_id;
        $stokBarang->stok_tanggal = $request->stok_tanggal;
        $stokBarang->stok_jumlah = $request->stok_jumlah;
        $stokBarang->save();

        return redirect('/stokBarang');
    }

    public function hapus($stok_id)
{
    $stokBarang = StokBarangModel::find($stok_id);
    $stokBarang->delete();

    return redirect('/StokBarang');
}

   // Ambil data user dalam bentuk json untuk datatables  
   public function list(Request $request) // tambahan 
   {  
       $stokBarang = StokBarangModel::select('stok_id', 'supplier_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah')  
                   ->with(['supplier', 'barang', 'user']); // jika ada relasi dengan supplier dan barang
        
      // Filter stok berdasarkan supplier_id jika diberikan
       if ($request->stok_id){ 
           $stokBarang->where('stok_id', $request->stok_id); 
       } 
    
       return DataTables::of($stokBarang)
        ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
        ->addColumn('aksi', function ($stokBarang) { // menambahkan kolom aksi 
            // $btn = '<a href="' . url('/level/' . $level->level_id) . '" class="btn btn-info btn-sm">Detail</a> '; //tidak menggunakan ajax
            $btn = '<button onclick="modalAction(\'' . url('/stokBarang/' . $stokBarang->stok_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> '; //menggunakan ajax
            $btn .= '<button onclick="modalAction(\'' . url('/stokBarang/' . $stokBarang->stok_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/stokBarang/' . $stokBarang->stok_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn;
        })
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
        ->make(true);  
   }
   

    // Menampilkan halaman form tambah user 
    public function create()
{
    $breadcrumb = (object) [
        'title' => 'Tambah Stok Barang',
        'list' => ['Home', 'Stok Barang', 'Tambah']
    ];
    $page = (object) [
        'title' => 'Tambah stok barang baru'
    ];

    $supplier = StokModel::all(); // ambil data supplier untuk ditampilkan di form
    $activeMenu = 'stokBarang';
    return view('stokBarang.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'supplier' => $supplier, 'activeMenu' => $activeMenu]);
}

public function store(Request $request)
{
    $request->validate([
        'stok_id' => 'required|integer',
        'supplier_id' => 'required|integer',
        'barang_id' => 'required|integer',
        'user_id' => 'required|integer',
        'stok_tanggal' => 'required|date',
        'stok_jumlah' => 'required|integer'
    ]);

    StokBarangModel::create([
        'stok_id' => $request->stok_id,
        'supplier_id' => $request->supplier_id,
        'barang_id' => $request->barang_id,
        'user_id' => $request->user_id,
        'stok_tanggal' => $request->stok_tanggal,
        'stok_jumlah' => $request->stok_jumlah
    ]);

    return redirect('/StokBarang')->with('success', 'Data stok barang berhasil disimpan');
}


public function show(string $stok_id)
{
    $stokBarang = StokBarangModel::with(['supplier', 'barang', 'user'])->where('stok_id', $stok_id)->first();
    $breadcrumb = (object) [
        'title' => 'Detail Stok Barang', 
        'list' => ['Home', 'Stok Barang', 'Detail']
    ];
    $page = (object) [
        'title' => 'Detail stok barang'
    ];
    $activeMenu = 'StokBarang';
    return view('stokBarang.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stokBarang' => $stokBarang, 'activeMenu' => $activeMenu]);
}

public function show_ajax(string $id)
    {
        $stokBarang = StokBarangModel::find($id);

        if (!$stokBarang) {
            return response()->json([
                'status' => false,
                'message' => 'Data level tidak ditemukan'
            ]);
        }

        return view('stokBarang.show_ajax', ['stokBarang' => $stokBarang]);
    }


    // Menampilkan halaman form edit user 
    public function edit(string $stok_id)
    {
        $stokBarang = StokBarangModel::find($stok_id);
        $supplier = StokModel::all();
    
        $breadcrumb = (object) [
            'title' => 'Edit Stok Barang',
            'list' => ['Home', 'Stok Barang', 'Edit']
        ];
    
        $page = (object) [
            "title" => 'Edit stok barang'
        ];
    
        $activeMenu = 'stokBarang';
        return view('stokBarang.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stokBarang' => $stokBarang, 'supplier' => $supplier, 'activeMenu' => $activeMenu]);
    }
    
    public function update(Request $request, string $stok_id)
    {
        $request->validate([
            'supplier_id' => 'required|integer',
            'barang_id' => 'required|integer',
            'user_id' => 'required|integer',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer'
        ]);
    
        StokBarangModel::find($stok_id)->update([
            'supplier_id' => $request->supplier_id,
            'barang_id' => $request->barang_id,
            'user_id' => $request->user_id,
            'stok_tanggal' => $request->stok_tanggal,
            'stok_jumlah' => $request->stok_jumlah
        ]);
    
        return redirect('/StokBarang')->with("success", "Data stok barang berhasil diubah");
    }
    
    // Menambah User Baru Ajax
    public function create_ajax() {
        $supplier = StokModel::select('supplier_id', 'supplier_id')-> get();
        $barang = BarangModel::select('barang_id', 'barang_id')-> get();
        $user = UserModel::select('user_id', 'user_id')-> get();

        return view('stokBarang.create_ajax')
            ->with('supplier', $supplier)
            ->with('barang', $barang)
            ->with('user', $user);
    }

    // Menyimpan data user baru Ajax 
    public function store_ajax(Request $request)
{
    // Cek apakah request berupa ajax
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'user_id'       => 'required|integer|exists:m_user,user_id',
            'supplier_id'   => 'required|integer|exists:m_supplier,supplier_id',
            'barang_id'     => 'required|integer|exists:m_barang,barang_id',
            'stok_tanggal'  => 'required|date',
            'stok_jumlah'   => 'required|integer|min:1',
        ];

        // Gunakan Illuminate\Support\Facades\Validator
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return response()->json([
                'status'    => false, // response status, false: error/gagal, true: berhasil
                'message'   => 'Validasi Gagal',
                'msgField'  => $validator->errors(), // pesan error validasi
            ]);
        }

        // Simpan data ke dalam tabel t_stok
        try {
            StokBarangModel::create([
                'user_id'       => $request->user_id,
                'supplier_id'   => $request->supplier_id,
                'barang_id'     => $request->barang_id,
                'stok_tanggal'  => $request->stok_tanggal,
                'stok_jumlah'   => $request->stok_jumlah,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Data stok barang berhasil disimpan',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
            ]);
        }
    }

    return redirect('/');
}



    //Menampilkan halaman form edit user ajax
    public function edit_ajax(string $stok_id)
{
    $stokBarang = StokBarangModel::find($stok_id);
    $supplier = StokModel::select('supplier_id', 'supplier_id')->get();
    $barang = BarangModel::select('barang_id', 'barang_id')->get();
    $user = UserModel::select('user_id', 'user_id')->get();

    return view('stokBarang.edit_ajax', [
        'stokBarang' => $stokBarang,
        'supplier' => $supplier,
        'barang' => $barang,
        'user' => $user
    ]);
}


public function update_ajax(Request $request, $stok_id)
{
    // cek apakah request dari ajax
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'stok_jumlah' => 'required|integer|min:1',
            'stok_tanggal' => 'nullable|date',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors() // menunjukkan field mana yang error
            ]);
        }

        $check = StokBarangModel::find($stok_id);

        if ($check) {
            // Hanya update jumlah stok dan tanggal jika diberikan
            $updateData = [
                'stok_jumlah' => $request->stok_jumlah,
            ];

            // Update stok_tanggal jika ada
            if ($request->has('stok_tanggal')) {
                $updateData['stok_tanggal'] = $request->stok_tanggal;
            }

            $check->update($updateData);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diupdate'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }
    return redirect('/');
}
public function delete_ajax(Request $request, $stok_id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $stokBarang = StokBarangModel::find($stok_id);
            if ($stokBarang) {
                $stokBarang->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
    public function confirm_ajax(string $stok_id)
    {
        $stokBarang = StokBarangModel::find($stok_id);
        return view('stokBarang.confirm_ajax', ['stokBarang' => $stokBarang]);
    }

    
    // Menghapus data supplier
    public function destroy(string $stok_id)
    {
        $stokBarang = StokBarangModel::find($stok_id);

        if (!$stokBarang) {
            return redirect('/stokBarang')->with('error', 'Data supplier tidak ditemukan');
        }

        try {
            $stokBarang->delete(); // Hapus data supplier
            return redirect('/stokBarang')->with('success', 'Data supplier berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/stokBarang')->with('error', 'Data supplier gagal dihapus karena masih terkait dengan data lain');
        }
    }

public function import()
{
    return view('stokBarang.import');
}

public function import_ajax(Request $request)
{
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'file_template_stokBarang' => ['required', 'mimes:xlsx', 'max:1024'], // Pastikan nama sesuai dengan input
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $file = $request->file('file_template_stokBarang'); // Ambil file dari request
        $reader = IOFactory::createReader('Xlsx'); // Load reader file excel
        $reader->setReadDataOnly(true); // Membaca data
        $spreadsheet = $reader->load($file->getRealPath()); // Load file excel
        $sheet = $spreadsheet->getActiveSheet(); // Mengambil sheet aktif
        $data = $sheet->toArray(null, false, true, true); // Ambil data excel

        $insert = [];
        if (count($data) > 1) {
            foreach ($data as $baris => $value) {
                if ($baris > 1) { // Mulai dari baris kedua untuk menghindari header
                    $insert[] = [
                        'stok_id' => $value['A'],
                        'supplier_id'     => $value['B'],
                        'barang_id'       => $value['C'],
                        'user_id' => $value['D'],
                        'stok_tanggal'    => $value['E'], // Contoh jika tanggal di kolom C
                        'stok_jumlah'     => $value['F'], // Pastikan sesuai dengan kolom
                        'created_at'      => now(),
                    ];
                }
            }
        }

        if (count($insert) > 0) {
            StokBarangModel::insertOrIgnore($insert);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil diimport'
        ]);
    } else {
        return response()->json([
            'status'  => false,
            'message' => 'Tidak ada data yang diimport'
        ]);
    }
}

public function export_excel()
{
    // Ambil data stok barang yang akan diexport
    $stokBarang = StokBarangModel::select('stok_id', 'supplier_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah')
        ->get();

    // Load library excel
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet(); // Ambil sheet yang aktif
    $sheet->setCellValue('A1', 'ID Stok');
    $sheet->setCellValue('B1', 'ID Supplier');
    $sheet->setCellValue('C1', 'ID Barang');
    $sheet->setCellValue('D1', 'ID User');
    $sheet->setCellValue('E1', 'Tanggal Stok');
    $sheet->setCellValue('F1', 'Jumlah Stok');

    $sheet->getStyle('A1:F1')->getFont()->setBold(true); // Bold header

    $baris = 2; // Baris data dimulai dari baris ke 2
    foreach ($stokBarang as $key => $value) {
        $sheet->setCellValue('A' . $baris, $value->stok_id);
        $sheet->setCellValue('B' . $baris, $value->supplier_id);
        $sheet->setCellValue('C' . $baris, $value->barang_id);
        $sheet->setCellValue('D' . $baris, $value->user_id);
        $sheet->setCellValue('E' . $baris, $value->stok_tanggal); // Format tanggal
        $sheet->setCellValue('F' . $baris, $value->stok_jumlah);
        $baris++;
    }

    foreach (range('A', 'F') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true); // Set auto size untuk kolom
    }
    
    $sheet->setTitle('Data Stok Barang'); // Set title sheet
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $filename = 'Data Stok Barang ' . date('Y-m-d H:i:s') . '.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Last-Modified:' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: cache, must-revalidate');
    header('Pragma: public');
    $writer->save('php://output');
    exit;
}
public function export_pdf()
{
    // Mengambil data stok barang beserta relasi supplier, barang, dan user
    $stokBarang = StokBarangModel::select('stok_id', 'supplier_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah')
        ->orderBy('stok_id')
        // ->orderBy('barang_id')
        // ->orderBy('user_id')
        ->with('supplier', 'barang', 'user')
        ->get();

    // Menggunakan Barryvdh\DomPDF\Facade\Pdf untuk membuat PDF
    $pdf = Pdf::loadView('stokBarang.export_pdf', ['stokBarang' => $stokBarang]);
    $pdf->setPaper('a4', 'portrait'); // Set ukuran kertas dan orientasi
    $pdf->setOption("isRemoteEnabled", true); // Set true jika ada gambar dari URL
    $pdf->render();

    // Mengembalikan hasil PDF dalam bentuk stream (langsung ditampilkan)
    return $pdf->stream('Data Stok Barang ' . date('Y-m-d H:i:s') . '.pdf');
}

}