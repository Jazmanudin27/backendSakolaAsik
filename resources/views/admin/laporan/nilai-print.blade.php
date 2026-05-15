<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Nilai Ujian</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            margin: 30px;
            color: #2c3e50;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #3498db;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #2c3e50;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            background: white;
        }

        .info-table td {
            padding: 10px 15px;
            border: 1px solid #e0e0e0;
        }

        .info-table td:first-child {
            font-weight: 600;
            width: 180px;
            background-color: #f8f9fa;
            color: #34495e;
        }

        .questions-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .questions-table th,
        .questions-table td {
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            vertical-align: middle;
        }

        .questions-table th {
            background-color: #3498db;
            color: white;
            font-weight: 600;
            text-align: center;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
        }

        .questions-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .score-high {
            background-color: #27ae60;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .score-medium {
            background-color: #f39c12;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .score-low {
            background-color: #e74c3c;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status-selesai {
            background-color: #27ae60;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status-mengerjakan {
            background-color: #3498db;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status-belum {
            background-color: #95a5a6;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #7f8c8d;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        @media print {
            body {
                margin: 15px;
            }

            .questions-table {
                box-shadow: none;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN NILAI UJIAN</h1>
    </div>

    <table class="info-table">
        @if ($selectedUjian)
            <tr>
                <td>Ujian</td>
                <td>{{ $selectedUjian->nama_ujian }}</td>
                <td>Kode Ujian</td>
                <td>{{ $selectedUjian->kode_ujian }}</td>
            </tr>
            <tr>
                <td>Mata Pelajaran</td>
                <td>{{ $selectedUjian->mapel->nama_mapel ?? '-' }}</td>
                <td>Tanggal Ujian</td>
                <td>{{ $selectedUjian->tanggal_ujian ? $selectedUjian->tanggal_ujian->format('d F Y') : '-' }}</td>
            </tr>
        @endif
        @if ($selectedKelas)
            <tr>
                <td>Kelas</td>
                <td>{{ $selectedKelas->nama_kelas }}</td>
                <td>Kode Kelas</td>
                <td>{{ $selectedKelas->kode_kelas }}</td>
            </tr>
        @endif
        <tr>
            <td>Total Siswa</td>
            <td>{{ $jawabanSiswa->count() }}</td>
            <td>Tanggal Cetak</td>
            <td>{{ now()->format('d F Y H:i') }}</td>
        </tr>
    </table>

    <table class="questions-table">
        <thead>
            <tr>
                <th style="width: 50px;">No</th>
                <th>Nama Siswa</th>
                <th>NIS</th>
                <th>Kelas</th>
                <th>Nilai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jawabanSiswa as $index => $item)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $item->siswa->nama_siswa ?? '-' }}</td>
                    <td>{{ $item->siswa->nis ?? '-' }}</td>
                    <td>{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                    <td style="text-align: center;">
                        @if ($item->nilai)
                            <span
                                class="@if ($item->nilai >= 80) score-high @elseif ($item->nilai >= 60) score-medium @else score-low @endif">
                                {{ $item->nilai }}
                            </span>
                        @else
                            -
                        @endif
                    </td>
                    <td style="text-align: center;">
                        <span
                            class="@if ($item->status == 'Selesai') status-selesai @elseif ($item->status == 'Sedang Mengerjakan') status-mengerjakan @else status-belum @endif">
                            {{ $item->status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">
                        Tidak ada data nilai
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
    </div>
</body>

</html>
