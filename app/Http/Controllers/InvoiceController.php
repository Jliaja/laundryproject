<?php
namespace App\Http\Controllers;

use App\Models\Pesanan;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function download($id)
    {
        $pesanan = Pesanan::with('user')->findOrFail($id);

        if (strtolower($pesanan->status) !== 'selesai') {
            return response()->json([
                'message' => 'Invoice hanya tersedia setelah pesanan selesai'
            ], 403);
        }

        $pdf = Pdf::loadView('user.downloadinvoice', [
            'pesanan' => $pesanan
        ]);

        return $pdf->stream(
            'invoice-' . $pesanan->id . '.pdf',
            ['Content-Type' => 'application/pdf']
        );
    }
}
