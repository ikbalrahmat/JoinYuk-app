<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Pemesanan Konsumsi - {{ $konsumsi->nomor_surat_nde }}</title>
    <style>
        body { font-family: 'Times New Roman', serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; }
        .info-table, .menu-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td, .menu-table th, .menu-table td { border: 1px solid #000; padding: 8px; text-align: left; }
        .menu-table th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Pemesanan Konsumsi</h1>
        <hr>
        <h3>No. NDE: {{ $konsumsi->nomor_surat_nde }}</h3>
    </div>

    <table class="info-table">
        <tr>
            <td>**Unit Kerja:** {{ $konsumsi->unit_kerja }}</td>
            <td>**Status:** {{ $konsumsi->status }}</td>
        </tr>
        <tr>
            <td>**Agenda Rapat:** {{ $konsumsi->agenda_rapat }}</td>
            <td>**Tahun Anggaran:** {{ $konsumsi->tahun_anggaran_rapat }}</td>
        </tr>
        <tr>
            <td>**Tanggal Rapat:** {{ $konsumsi->tanggal_rapat->format('d-m-Y') }}</td>
            <td>**Jam Rapat:** {{ $konsumsi->jam_rapat }}</td>
        </tr>
        <tr>
            <td>**Total Biaya:** @if ($konsumsi->total_biaya)
                    Rp {{ number_format($konsumsi->total_biaya, 0, ',', '.') }}
                @else
                    Belum Dikonfirmasi
                @endif
            </td>
            <td>**Dokumen NDE:** {{ $konsumsi->unggah_dokumen_nde ?? 'Tidak ada' }}</td>
        </tr>
    </table>

    <h4>Detail Menu Konsumsi</h4>
    <table class="menu-table">
        <thead>
            <tr>
                <th>Menu</th>
                <th>Detail</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($konsumsi->menu_konsumsi as $item)
                <tr>
                    <td>{{ $item['menu'] }}</td>
                    <td>{{ $item['detail'] ?? '-' }}</td>
                    <td>{{ $item['jumlah'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Informasi Distribusi</h4>
    <p>Distribusi Tujuan: {{ $konsumsi->distribusi_tujuan }}</p>
    <p>Lokasi: {{ $konsumsi->lokasi_unit_kerja }}</p>
    <p>Catatan: {{ $konsumsi->catatan ?? '-' }}</p>

    <br><br>
    <p>Tanda tangan: {{ $konsumsi->tanda_tangan ?? 'Belum ada' }}</p>
</body>
</html>
