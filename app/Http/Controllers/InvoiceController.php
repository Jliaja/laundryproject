<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Pesanan;

class InvoiceController extends Controller
{
    public function download($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        if ($pesanan->status != 'selesai') {
            return redirect()->back()->with('error', 'Invoice hanya bisa diunduh jika pesanan selesai.');
        }

        $pdf = Pdf::loadView('user.downloadinvoice', compact('pesanan'));
        return $pdf->download("invoice-pesanan-{$pesanan->id}.pdf");
    }
}

