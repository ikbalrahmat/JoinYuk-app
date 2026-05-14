<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\PresenceDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PresenceDetailController extends Controller
{
    /**
     * Export detail absen ke PDF
     */
    public function exportPdf(Request $request, string $id)
    {
        $logoOption = $request->query('logo_option', 'both');
        $presence = Presence::findOrFail($id);
        $presenceDetails = PresenceDetail::where('presence_id', $id)->get();

        // Path gambar bukti kegiatan
        $buktiPath = null;
        if ($presence->bukti_kegiatan) {
            $buktiPath = public_path('storage/bukti/' . $presence->bukti_kegiatan);
        }

        // load view untuk PDF dan kirim data gambar
        $pdf = Pdf::setOptions(['isRemoteEnabled' => true])
            ->loadView('pages.presence.detail.export-pdf', compact('presence', 'presenceDetails', 'buktiPath', 'logoOption'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream("{$presence->nama_kegiatan}.pdf", ['Attachment' => 0]);
    }

    /**
     * Hapus satu data detail absen (AJAX)
     */
    public function destroy($id)
    {
        $presenceDetail = PresenceDetail::find($id);

        if (!$presenceDetail) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        // Hapus file tanda tangan (kalau ada)
        if ($presenceDetail->tanda_tangan) {
            Storage::disk('public_uploads')->delete($presenceDetail->tanda_tangan);
        }

        // Hapus data dari database
        $presenceDetail->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus.'
        ]);
    }
}
