<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Harga;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class AdminController extends Controller
{
    // Dashboard Admin
    public function dashboard()
    {
        return view('admin.dashboard');
    }


    // Kelola Pesanan
    public function kelolaPesanan()
{
    $pesanans = Pesanan::all(); // ambil data terbaru dari DB setiap akses halaman
    return view('admin.kelola', compact('pesanans'));
}


    // Update pesanan
    public function updateMassal(Request $request)
{
    $data = $request->input('pesanans', []);

    foreach ($data as $id => $values) {
        $pesanan = Pesanan::find($id);
        if (!$pesanan) continue;

        // Update status
        if (isset($values['status'])) {
            $pesanan->status = $values['status'];
        }

        // Update jumlah (berat cucian)
        if (isset($values['jumlah'])) {
            $pesanan->jumlah = floatval($values['jumlah']);

            // Hitung total harga sebelum diskon
            $hargaRecord = Harga::where('layanan', $pesanan->layanan)->first();
            if ($hargaRecord) {
                $total = $pesanan->jumlah * $hargaRecord->hargaPerKg;
                $pesanan->total_harga = $total;
            } else {
                $total = 0;
                $pesanan->total_harga = 0;
            }

            $diskon = 0;
            if ($pesanan->voucher_id) {
                $voucher = Voucher::find($pesanan->voucher_id);

                if ($voucher) {
                    // Hitung diskon
                    if ($voucher->tipe === 'persen') {
                        $diskon = $total * ($voucher->nilai / 100);
                    } else {
                        $diskon = $voucher->nilai;
                    }

                    if ($diskon > $total) $diskon = $total;

                    // Update terpakai, pastikan tidak lebih dari stok
                    if ($voucher->terpakai < $voucher->stok) {
                        $voucher->terpakai += 1;
                        $voucher->save();
                    }
                }
            }


            // Simpan diskon dan total akhir
            $pesanan->diskon = $diskon;
            $pesanan->total_akhir = $total - $diskon;
        }

        $pesanan->save();
    }

    return redirect()->back()->with('success', 'Semua pesanan berhasil diperbarui.');
}



    // Kelola Harga
    // public function kelolaHargaPesanan()
    
    // {
    //     $hargas = Harga::all();
    //     return view('admin.harga', compact('hargas'));
    // }

     public function kelolaVoucher()
    {
        $vouchers = Voucher::orderBy('id', 'DESC')->get();
        return view('admin.kelolavoucher', compact('vouchers'));
    }

    public function storeVoucher(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:vouchers,kode',
            'tipe' => 'required|in:persen,nominal',
            'nilai' => 'required|integer|min:1',
            'stok' => 'required|integer|min:1',
            'masa_berlaku' => 'required|date'
        ]);

        Voucher::create($request->all());

        return back()->with('success', 'Voucher berhasil dibuat!');
    }

    public function hapusVoucher($id)
    {
        Voucher::findOrFail($id)->delete();
        return back()->with('success', 'Voucher berhasil dihapus!');
    }

    public function backupDatabase()
{
    $tables = DB::select('SHOW TABLES');
   $first = get_object_vars($tables[0]);
$key = array_keys($first)[0];

    $sql = "-- Backup Laravel - " . now() . "\n\n";

    foreach ($tables as $table) {
        $tableName = $table->$key;

        // ===== Structure =====
        $create = DB::select("SHOW CREATE TABLE `$tableName`")[0]->{"Create Table"};
        $sql .= "DROP TABLE IF EXISTS `$tableName`;\n";
        $sql .= $create . ";\n\n";

        // ===== Data =====
        $rows = DB::table($tableName)->get();

        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $values = array_map(function ($v) {
                    return $v === null ? "NULL" : "'" . addslashes($v) . "'";
                }, (array) $row);

                $sql .= "INSERT INTO `$tableName` VALUES (" . implode(",", $values) . ");\n";
            }
        }

        $sql .= "\n\n";
    }

    // Nama file backup
    $filename = "backup-laundry-" . date('Y-m-d_H-i-s') . ".sql";

    // Download file
    return Response::make($sql, 200, [
        'Content-Type' => 'application/sql',
        'Content-Disposition' => "attachment; filename=\"$filename\"",
    ]);
}

}
