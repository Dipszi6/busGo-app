<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>E-Tiket BusGo</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f3f6f4; font-family: Arial, sans-serif; color: #253C34;">
    @php
        $jadwal = $pemesanan->jadwal;
        $rute = $jadwal->rute;
    @endphp

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f3f6f4; padding: 30px 15px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background-color: #ffffff; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0;">
                    <tr>
                        <td style="background-color: #174E3F; padding: 24px 30px; color: #ffffff;">
                            <div style="font-size: 20px; font-weight: bold;">BusGo</div>
                            <div style="font-size: 13px; color: #DDEAE3; margin-top: 4px;">Pembayaran Berhasil &bull;
                                E-Tiket Resmi</div>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 30px;">
                            <p style="margin: 0 0 12px; font-size: 15px;">
                                Halo, <strong>{{ $pemesanan->user->name }}</strong>!
                            </p>
                            <p style="margin: 0 0 20px; font-size: 14px; color: #64756D; line-height: 1.5;">
                                Terima kasih telah memesan tiket melalui BusGo. Pembayaran Anda telah dikonfirmasi.
                                Berikut adalah ringkasan perjalanan Anda (file PDF E-Tiket juga terlampir pada email
                                ini):
                            </p>

                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="background-color: #F6F9F7; border-radius: 10px; font-size: 13px; margin-bottom: 24px;">
                                <tr>
                                    <td style="color: #64756D;">Kode Pemesanan</td>
                                    <td align="right"
                                        style="font-weight: bold; color: #174E3F; font-size: 15px; letter-spacing: 1px;">
                                        {{ $pemesanan->kode }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #64756D;">Armada</td>
                                    <td align="right" style="font-weight: bold;">{{ $jadwal->bus->nama }}
                                        ({{ $jadwal->bus->kelas }})</td>
                                </tr>
                                <tr>
                                    <td style="color: #64756D;">Rute</td>
                                    <td align="right" style="font-weight: bold;">{{ $rute->terminalAsal->kota->nama }}
                                        &rarr; {{ $rute->terminalTujuan->kota->nama }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #64756D;">Keberangkatan</td>
                                    <td align="right" style="font-weight: bold;">
                                        {{ $pemesanan->tanggal_berangkat->locale('id')->translatedFormat('d F Y') }},
                                        {{ $jadwal->jam_berangkat_tampil }} WIB</td>
                                </tr>
                                <tr>
                                    <td style="color: #64756D;">Nomor Kursi</td>
                                    <td align="right" style="font-weight: bold;">
                                        {{ $pemesanan->penumpang->pluck('nomor_kursi')->sort()->implode(', ') }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #64756D;">Total Dibayar</td>
                                    <td align="right" style="font-weight: bold; color: #174E3F;">
                                        Rp{{ number_format($pemesanan->total_harga, 0, ',', '.') }}</td>
                                </tr>
                            </table>

                            <div style="text-align: center; margin: 28px 0 10px;">
                                <a href="{{ route('pemesanan.etiket', $pemesanan->kode) }}"
                                    style="display: inline-block; background-color: #174E3F; color: #ffffff; text-decoration: none; font-weight: bold; font-size: 14px; padding: 14px 28px; border-radius: 10px;">
                                    Buka E-Tiket di Browser
                                </a>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td
                            style="background-color: #F6F9F7; padding: 18px 30px; text-align: center; font-size: 12px; color: #64756D;">
                            Harap tiba di terminal minimal 30 menit sebelum keberangkatan.<br>
                            &copy; {{ date('Y') }} BusGo Indonesia
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
