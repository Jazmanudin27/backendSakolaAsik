<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Ujian Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .info-table td {
            padding: 3px;
            border: 1px solid #ddd;
        }

        .info-table td:first-child {
            font-weight: bold;
            width: 150px;
            background-color: #f5f5f5;
        }

        .score-summary {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
            text-align: center;
        }

        .score-item {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            min-width: 100px;
        }

        .score-item h3 {
            margin: 0;
            font-size: 24px;
        }

        .score-item p {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: #666;
        }

        .questions-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .questions-table th,
        .questions-table td {
            padding: 8px;
            border: 1px solid #ddd;
            vertical-align: top;
        }

        .questions-table th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-align: center;
        }

        .correct {
            background-color: #d4edda;
            color: #155724;
        }

        .wrong {
            background-color: #f8d7da;
            color: #721c24;
        }

        .unanswered {
            background-color: #fff3cd;
            color: #856404;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        @media print {
            body {
                margin: 10px;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN HASIL UJIAN SISWA</h1>
    </div>

    <table class="info-table">
        <tr>
            <td>Nama Siswa</td>
            <td>{{ $jawabanSiswa->siswa->nama_siswa }}</td>
            <td>NIS</td>
            <td>{{ $jawabanSiswa->siswa->nis }}</td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>{{ $jawabanSiswa->siswa->kelas->nama_kelas }}</td>
            <td>Kode Ujian</td>
            <td>{{ $jawabanSiswa->ujian->kode_ujian }}</td>
        </tr>
        <tr>
            <td>Mata Pelajaran</td>
            <td>{{ $jawabanSiswa->ujian->mapel->nama_mapel }}</td>
            <td>Tanggal Ujian</td>
            <td>{{ $jawabanSiswa->ujian->tanggal_ujian->format('d F Y') }}</td>
        </tr>
        <tr>
            <td>Waktu Mulai</td>
            <td>{{ $jawabanSiswa->waktu_mulai->format('H:i') }}</td>
            <td>Waktu Selesai</td>
            <td>{{ $jawabanSiswa->waktu_selesai->format('H:i') }}</td>
        </tr>
    </table>

    <div class="score-summary">
        <div class="score-item">
            <h3>{{ $scoreDetails['total_max_score'] > 0 ? round(($scoreDetails['total_score'] / $scoreDetails['total_max_score']) * 100, 1) : 0 }}%
            </h3>
            <p>Nilai Akhir</p>
        </div>
        <div class="score-item">
            <h3>{{ $scoreDetails['total_score'] }}/{{ $scoreDetails['total_max_score'] }}</h3>
            <p>Skor</p>
        </div>
        <div class="score-item">
            <h3>{{ $scoreDetails['correct_count'] }}</h3>
            <p>Benar</p>
        </div>
        <div class="score-item">
            <h3>{{ $scoreDetails['wrong_count'] }}</h3>
            <p>Salah</p>
        </div>
    </div>

    <table class="questions-table">
        <thead>
            <tr>
                <th style="width: 3%;">No</th>
                <th style="width: 15%;">Tipe Soal</th>
                <th>Jawaban Siswa</th>
                <th style="width: 15%;">Kunci Jawaban</th>
                <th style="width: 10%;">Nilai</th>
            </tr>
        </thead>
        <tbody>
            @php
                $detailUjians = \App\Models\DetailUjian::where('id_ujian', $jawabanSiswa->id_ujian)
                    ->orderByRaw("FIELD(tipe_soal, 'pilihan_ganda', 'benar_salah', 'isian_singkat','essay')")
                    ->orderByRaw("FIELD(tingkat_kesulitan, 'mudah', 'sedang', 'sulit', 'tinggi')")
                    ->get();

                $studentAnswers = \App\Models\DetailJawabanSiswa::where('id_jawaban_siswa', $jawabanSiswa->id)
                    ->get()
                    ->keyBy('id_detail_ujian');
            @endphp

            @foreach ($detailUjians as $index => $soal)
                @php
                    $isCorrect = false;
                    $studentAnswer = 'Tidak dijawab';
                    $rowClass = 'unanswered';

                    if (isset($studentAnswers[$soal->id])) {
                        $studentAnswer = $studentAnswers[$soal->id]->jawaban;
                        $isCorrect = strtolower($studentAnswer) == strtolower($soal->kunci_jawaban);
                        $rowClass = $isCorrect ? 'correct' : 'wrong';
                    }
                @endphp

                <tr class="{{ $rowClass }}">
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ ucfirst(str_replace('_', ' ', $soal->tipe_soal)) }}</td>
                    <td>{{ $studentAnswer }}</td>
                    <td>{{ $soal->kunci_jawaban }}</td>
                    <td class="text-center">{{ $isCorrect ? $soal->bobot : 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>
        <p>Sistem Ujian Online Sekolah</p>
    </div>

    <script>
        window.onload = function() {
            // window.print();
        }
    </script>
</body>

</html>
