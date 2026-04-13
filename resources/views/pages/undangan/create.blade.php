@extends('layouts.main')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Formulir Undangan Rapat</h2>

    <div class="bg-white rounded-2xl shadow p-6">
        <form action="{{ route('undangan.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Rapat</label>
                    <input type="date" id="tanggal" name="tanggal" required
                        class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="jam" class="block text-sm font-medium text-gray-700 mb-1">Jam Rapat</label>
                    <input type="time" id="jam" name="jam" required
                        class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="mt-4">
                <label for="kepada" class="block text-sm font-medium text-gray-700 mb-1">Kepada</label>
                <input type="text" id="kepada" name="kepada" required
                    placeholder="Contoh: Tim Developer"
                    class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mt-4">
                <label for="pengirim" class="block text-sm font-medium text-gray-700 mb-1">Pengirim</label>
                <input type="text" id="pengirim" name="pengirim" required
                    placeholder="Contoh: Manajer Proyek"
                    class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mt-4">
                <label for="tempat_link" class="block text-sm font-medium text-gray-700 mb-1">Tempat / Link</label>
                <input type="text" id="tempat_link" name="tempat_link" required
                    placeholder="Contoh: Ruang Rapat A / Link Zoom"
                    class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mt-4">
                <label for="agenda" class="block text-sm font-medium text-gray-700 mb-1">Agenda (ringkas)</label>
                <textarea id="agenda" name="agenda" rows="3" required
                    placeholder="Contoh: Diskusi progres proyek aplikasi."
                    class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>

            {{-- Tanda Tangan --}}
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanda Tangan</label>
                <div class="border border-gray-300 rounded-lg bg-gray-50">
                    <canvas id="signatureCanvas" class="w-full" height="150"></canvas>
                </div>
                <small class="text-gray-500">Silakan tanda tangan di area di atas.</small>
                <button type="button" id="clearSignature"
                    class="mt-2 inline-flex items-center px-3 py-1.5 text-sm border border-red-500 text-red-600 rounded-lg hover:bg-red-50">
                    Hapus Tanda Tangan
                </button>
                <input type="hidden" name="tanda_tangan" id="signatureInput">
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('undangan.index') }}"
                    class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                    Batal
                </a>
                <button type="submit"
                    class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 shadow">
                    Simpan Undangan
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const canvas = document.getElementById('signatureCanvas');
        const signatureInput = document.getElementById('signatureInput');

        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
        }

        resizeCanvas();
        window.addEventListener("resize", resizeCanvas);

        const signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgb(248, 249, 250)'
        });

        document.getElementById('clearSignature').addEventListener('click', function () {
            signaturePad.clear();
        });

        document.querySelector('form').addEventListener('submit', function (event) {
            if (signaturePad.isEmpty()) {
                alert("Harap berikan tanda tangan terlebih dahulu.");
                event.preventDefault();
            } else {
                signatureInput.value = signaturePad.toDataURL();
            }
        });
    });
</script>
@endsection
