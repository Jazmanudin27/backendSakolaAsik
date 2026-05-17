<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Ujian</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @page {
            size: A4 landscape;
            margin: 5mm;
        }

        body {
            background: #f5f5f5;
        }

        .a4-page {
            min-height: 297mm;
            margin: auto;
            background: white;
            padding: 8mm;
        }

        .card-ujian {
            border: 2px solid #000;
            height: 111mm;
            position: relative;
            overflow: hidden;
            background: #fff;
        }

        .header-sekolah {
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            margin-bottom: 8px;
        }

        .logo-sekolah {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }

        .nama-yayasan {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .nama-sekolah {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .sub-sekolah {
            font-size: 12px;
            font-weight: 600;
        }

        .akreditasi {
            font-size: 12px;
            font-style: italic;
        }

        .alamat {
            font-size: 12px;
            line-height: 1.3;
        }

        .judul-kartu {
            text-align: center;
            margin-top: 5px;
        }

        .judul-kartu h5 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 3px;
        }

        .judul-kartu h6 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 3px;
        }

        .data-peserta {
            font-size: 15px;
        }

        .data-peserta td {
            padding: 1px 0;
        }

        .footer-ttd {
            position: absolute;
            right: 15px;
            text-align: center;
            font-size: 13px;
        }

        .ttd-space {
            height: 50px;
        }

        @media print {

            body {
                background: white;
            }

            .a4-page {
                margin: 0;
                width: 100%;
                min-height: auto;
                padding: 0;
            }

            .card-ujian {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>

    <div class="a4-page">

        <div class="row g-2">

            @if ($siswa->isNotEmpty())
                @foreach ($siswa as $s)
                    <div class="col-4">
                        <div class="card-ujian p-2">

                            <div class="header-sekolah">
                                <div class="row align-items-center">
                                    <div class="col-2 text-center">
                                        @if ($s->sekolah && $s->sekolah->logo)
                                            <img src="{{ asset('storage/sekolah/' . $s->sekolah->logo) }}"
                                                class="logo-sekolah" alt="Logo Sekolah">
                                        @else
                                            <img src="{{ asset('images/logo-default.png') }}" class="logo-sekolah"
                                                alt="Logo Default">
                                        @endif
                                    </div>
                                    @php
                                        $jenjang = strtoupper($s->sekolah->jenjang ?? '');

                                        $namaJenjang = match ($jenjang) {
                                            'SMK' => 'SEKOLAH MENENGAH KEJURUAN',
                                            'SMA' => 'SEKOLAH MENENGAH ATAS',
                                            'MA' => 'MADRASAH ALIYAH',
                                            'SMP' => 'SEKOLAH MENENGAH PERTAMA',
                                            'MTS', 'MTs' => 'MADRASAH TSANAWIYAH',
                                            'SD' => 'SEKOLAH DASAR',
                                            'MI' => 'MADRASAH IBTIDAIYAH',
                                            'TK' => 'TAMAN KANAK-KANAK',
                                            default => 'SAKOLA DIGITAL',
                                        };
                                    @endphp
                                    <div class="col-10 text-center">
                                        <div class="nama-yayasan">
                                            {{ $s->sekolah->nama_yayasan ?? 'YAYASAN ' }}
                                            {{ $s->sekolah->nama_sekolah ?? '' }}
                                        </div>
                                        <div class="nama-yayasan">
                                            {{ $namaJenjang }}
                                        </div>
                                        <div class="sub-sekolah">
                                            {{ $s->sekolah->alamat ?? '' }} | {{ $s->sekolah->no_telp ?? '' }}
                                        </div>

                                        <div class="akreditasi">
                                            {{ $s->sekolah->kabupaten_kota ?? '-' }},
                                            {{ $s->sekolah->provinsi ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="judul-kartu">
                                <h5>KARTU PESERTA UJIAN</h5>
                                <h5>{{ $selectedUjian->nama_ujian ?? 'UJIAN' }}</h5>
                                <h5>{{ $selectedUjian->tahun_ajaran ?? 'TAHUN PELAJARAN ' . date('Y') }}</h5>
                            </div>

                            <table class="table-borderless data-peserta">

                                <tr>
                                    <td>NIS</td>
                                    <td>:</td>
                                    <td>{{ $s->nis ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td width="70">Nama</td>
                                    <td width="10">:</td>
                                    <td>{{ $s->nama_siswa }}</td>
                                </tr>

                                <tr>
                                    <td>Kelas</td>
                                    <td>:</td>
                                    <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Ruangan</td>
                                    <td>:</td>
                                    <td></td>
                                </tr>
                            </table>

                            <div class="footer-ttd">
                                {{ $s->sekolah->kota ?? 'Tasikmalaya' }},
                                {{ \Carbon\Carbon::now()->format('F Y') }}<br>
                                Kepala Sekolah
                                <div class="ttd-space"></div>
                                <strong>
                                    {{ $s->sekolah->kepala_sekolah ?? '-' }}
                                </strong><br>
                                NIP: {{ $s->sekolah->nip_kepala_sekolah ?? '-' }}
                            </div>

                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center py-5">
                    <p>Tidak ada data siswa ditemukan</p>
                </div>
            @endif

        </div>

    </div>

    <script>
        window.onload = function() {
            // window.print();
        };
    </script>

</body>

</html>
