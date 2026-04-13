<!DOCTYPE html>
<html>
<head>
    <title>Undangan Rapat</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 800px; margin: auto; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .content { margin-bottom: 30px; }
        .signature { margin-top: 50px; text-align: right; }
        .signature-img { max-width: 200px; height: auto; display: block; margin-left: auto; margin-right: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Undangan Rapat</h2>
        </div>
        <div class="content">
            <p>Kepada Yth. <br> <strong>{{ $undangan->kepada }}</strong></p>
            <p>Bersama ini kami mengundang Saudara/i untuk hadir dalam rapat:</p>
            <table>
                <tr>
                    <td><strong>Pengirim</strong></td>
                    <td>:</td>
                    <td>{{ $undangan->pengirim }}</td>
                </tr>
                <tr>
                    <td><strong>Hari, Tanggal, Jam</strong></td>
                    <td>:</td>
                    <td>{{ date('d F Y', strtotime($undangan->tanggal)) }}, {{ date('H:i', strtotime($undangan->jam)) }} WIB</td>
                </tr>
                <tr>
                    <td><strong>Tempat / Link Rapat</strong></td>
                    <td>:</td>
                    <td>{{ $undangan->tempat_link }}</td>
                </tr>
                <tr>
                    <td><strong>Agenda</strong></td>
                    <td>:</td>
                    <td>{{ $undangan->agenda }}</td>
                </tr>
            </table>
            <p style="margin-top: 20px;">Demikian undangan ini kami sampaikan, atas perhatian dan kehadirannya kami ucapkan terima kasih.</p>
        </div>
        <div class="signature">
            <p>Hormat kami,</p>
            @if($undangan->tanda_tangan)
                <img src="{{ $undangan->tanda_tangan }}" alt="Tanda Tangan" class="signature-img">
            @endif
            <p><strong>{{ $undangan->pengirim }}</strong></p>
        </div>
    </div>
</body>
</html>
