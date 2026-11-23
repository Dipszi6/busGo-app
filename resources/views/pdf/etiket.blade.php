<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>E-Tiket {{ $pemesanan->kode }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #253C34;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }

        .card {
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 24px;
        }

        .header-table,
        .route-table,
        .passenger-table {
            width: 100%;
            border-collapse: collapse;
        }

        .brand {
            font-size: 20px;
            font-weight: bold;
            color: #174E3F;
        }

        .badge-lunas {
            background-color: #DDEAE3;
            color: #174E3F;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
        }

        .kode {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 2px;
            color: #174E3F;
        }

        .divider {
            border-top: 1px dashed #94a3b8;
            margin: 18px 0;
        }

        .box-bus {
            background-color: #F6F9F7;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 16px;
        }

        .passenger-table th {
            background-color: #F6F9F7;
            color: #64756D;
            font-size: 11px;
            padding: 8px 10px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .passenger-table td {
            padding: 9px 10px;
            border-bottom: 1px solid #f1f5f9;
        }

        .seat-badge {
            background-color: #174E3F;
            color: #ffffff;
            padding: 3px 8px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 11px;
        }

        .footer-box {
            background-color: #DDEAE3;
            padding: 12px;
            border-radius: 8px;
            margin-top: 18px;
        }
    </style>
</head>

<body>
    @php
        $jadwal = $pemesanan->jadwal;
        $rute = $jadwal->rute;
        $bus = $jadwal->bus;
    @endphp

    <div class="card">
        <table class="header-table">
            <tr>
                <td>
                    <div class="brand">BusGo <span style="font-size: 11px; font-weight: normal; color: #64756D;">|
                            E-Tiket Resmi</span></div>
                    <div style="font-size: 10px; color: #64756D; margin-top: 4px;">
                        Diterbitkan:
                        {{ ($pemesanan->dibayar_pada ?? $pemesanan->updated_at)->locale('id')->translatedFormat('d F Y, H:i') }}
                        WIB
                    </div>
                </td>
                <td style="text-align: right;">
                    <div style="font-size: 10px; color: #64756D;">KODE PEMESANAN</div>
                    <div class="kode">{{ $pemesanan->kode }}</div>
                    <div style="margin-top: 4px;"><span class="badge-lunas">LUNAS</span></div>
                </td>
            </tr>
        </table>

        <div class="divider"></div>

        <div class="box-bus">
            <table style="width: 100%;">
                <tr>
                    <td>
                        <div style="font-size: 10px; color: #64756D;">Armada & Kelas</div>
                        <div style="font-weight: bold; font-size: 13px;">{{ $bus->nama }} ({{ $bus->kelas }})</div>
                    </td>
                    <td style="text-align: right;">
                        <div style="font-size: 10px; color: #64756D;">Tanggal Keberangkatan</div>
                        <div style="font-weight: bold; font-size: 13px;">
                            {{ $pemesanan->tanggal_berangkat->locale('id')->translatedFormat('l, d F Y') }}</div>
                    </td>
                </tr>
            </table>
        </div>

        <table class="route-table">
            <tr>
                <td style="width: 38%;">
                    <div style="font-size: 18px; font-weight: bold;">{{ $jadwal->jam_berangkat_tampil }} WIB</div>
                    <div style="font-weight: bold; color: #174E3F; margin-top: 2px;">
                        {{ $rute->terminalAsal->kota->nama }}</div>
                    <div style="font-size: 11px; color: #64756D;">{{ $rute->terminalAsal->nama }}</div>
                </td>
                <td style="width: 24%; text-align: center;">
                    <div style="font-size: 10px; color: #174E3F; font-weight: bold;">{{ $rute->durasi_tampil }}</div>
                    <div style="border-top: 1px dashed #174E3F; margin: 6px 10px;"></div>
                    <div style="font-size: 10px; color: #64756D;">Estimasi</div>
                </td>
                <td style="width: 38%; text-align: right;">
                    <div style="font-size: 18px; font-weight: bold;">{{ $jadwal->jam_tiba }} WIB</div>
                    <div style="font-weight: bold; color: #174E3F; margin-top: 2px;">
                        {{ $rute->terminalTujuan->kota->nama }}</div>
                    <div style="font-size: 11px; color: #64756D;">{{ $rute->terminalTujuan->nama }}</div>
                </td>
            </tr>
        </table>

        <div class="divider"></div>

        <div style="font-size: 11px; font-weight: bold; color: #64756D; margin-bottom: 8px;">
            DAFTAR PENUMPANG ({{ $pemesanan->penumpang->count() }} ORANG)
        </div>

        <table class="passenger-table">
            <thead>
                <tr>
                    <th style="width: 8%;">No</th>
                    <th style="width: 47%;">Nama Penumpang</th>
                    <th style="width: 25%;">NIK</th>
                    <th style="width: 20%; text-align: right;">Kursi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pemesanan->penumpang->sortBy('nomor_kursi')->values() as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <strong>{{ $p->nama }}</strong><br>
                            <span
                                style="font-size: 10px; color: #64756D;">{{ $p->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                &bull; {{ $p->telepon }}</span>
                        </td>
                        <td>{{ $p->nik }}</td>
                        <td style="text-align: right;"><span class="seat-badge">{{ $p->nomor_kursi }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer-box">
            <table style="width: 100%;">
                <tr>
                    <td style="font-size: 10px;">
                        <strong style="color: #174E3F;">Ketentuan Check-in:</strong><br>
                        1. Hadir di terminal minimal 30 menit sebelum keberangkatan.<br>
                        2. Tunjukkan E-Tiket ini beserta identitas (KTP/SIM) asli.
                    </td>
                    <td style="text-align: right;">
                        <div style="font-size: 10px; color: #64756D;">Total Dibayar</div>
                        <div style="font-size: 16px; font-weight: bold; color: #174E3F;">
                            Rp{{ number_format($pemesanan->total_harga, 0, ',', '.') }}
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
