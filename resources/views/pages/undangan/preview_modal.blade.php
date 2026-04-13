<div class="p-8">
    <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Undangan Rapat</h2>

    <div id="undangan-text-content" class="space-y-4 text-gray-700 leading-relaxed">
        <p>Kepada Yth.<br>
            <span class="font-semibold text-lg">{{ $undangan->kepada }}</span>
        </p>

        <p>Dengan hormat,</p>

        <p>
            Bersama ini kami mengundang Saudara/i untuk hadir dalam rapat dengan detail sebagai berikut:
        </p>

        <div class="border border-gray-300 rounded-lg overflow-hidden">
            <table class="w-full text-sm">
                <tbody>
                    <tr class="border-b">
                        <td class="px-4 py-2 font-semibold w-40 bg-gray-50">Pengirim</td>
                        <td class="px-4 py-2">{{ $undangan->pengirim }}</td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-4 py-2 font-semibold bg-gray-50">Hari, Tanggal, Jam</td>
                        <td class="px-4 py-2">
                            {{ date('l, d F Y', strtotime($undangan->tanggal)) }},
                            {{ date('H:i', strtotime($undangan->jam)) }} WIB
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-4 py-2 font-semibold bg-gray-50">Tempat / Link Rapat</td>
                        <td class="px-4 py-2">{{ $undangan->tempat_link }}</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-semibold bg-gray-50">Agenda</td>
                        <td class="px-4 py-2">{{ $undangan->agenda }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <p>
            Demikian undangan ini kami sampaikan. Atas perhatian dan kehadirannya kami ucapkan terima kasih.
        </p>

        <div class="mt-6 text-center">
            <p>Hormat kami,</p>
            @if($undangan->tanda_tangan)
                <div class="my-3">
                    <img src="{{ $undangan->tanda_tangan }}" alt="Tanda Tangan"
                        class="h-20 object-contain mx-auto">
                </div>
            @endif
            <p class="font-semibold">{{ $undangan->pengirim }}</p>
        </div>
    </div>

    <div class="mt-8 flex flex-wrap gap-3 justify-center">
        <a href="https://wa.me/?text={{ urlencode("Undangan Rapat: \nKepada: {$undangan->kepada}\nPengirim: {$undangan->pengirim}\nHari, Tanggal, Jam: " . date('d F Y', strtotime($undangan->tanggal)) . ", " . date('H:i', strtotime($undangan->jam)) . " WIB\nTempat/Link: {$undangan->tempat_link}\nAgenda: {$undangan->agenda}") }}"
            target="_blank"
            class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 flex items-center gap-2">
            <i class="fab fa-whatsapp"></i> WhatsApp
        </a>

        <a href="mailto:?subject=Undangan Rapat&body={{ urlencode("Kepada Yth. {$undangan->kepada},\n\nDengan hormat,\n\nBersama ini kami mengundang Saudara/i untuk hadir dalam rapat:\n\nPengirim: {$undangan->pengirim}\nHari, Tanggal, Jam: " . date('d F Y', strtotime($undangan->tanggal)) . ", " . date('H:i', strtotime($undangan->jam)) . " WIB\nTempat / Link Rapat: {$undangan->tempat_link}\nAgenda: {$undangan->agenda}\n\nDemikian undangan ini kami sampaikan, atas perhatian dan kehadirannya kami ucapkan terima kasih.\n\nHormat kami,\n{$undangan->pengirim}") }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2">
            <i class="fa fa-envelope"></i> Email
        </a>

        <button onclick="copyToClipboard('undangan-text-content')"
            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 flex items-center gap-2">
            <i class="fa fa-clipboard"></i> Salin
        </button>

        <a href="{{ route('undangan.exportPdf', $undangan->id) }}"
            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 flex items-center gap-2">
            <i class="fa fa-file-pdf"></i> Export PDF
        </a>
    </div>
</div>
