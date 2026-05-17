<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Ujian</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @page {
            size: A4 landscape;
            margin: 6mm;
        }

        body {
            background: #f5f5f5;
        }

        .a4-page {
            width: 100%;
            margin: auto;
            background: #fff;
            padding: 1mm;
        }

        .row-kartu {
            display: flex;
            flex-wrap: wrap;
            gap: 4mm;
        }

        .col-kartu {
            width: calc(33.333% - 3mm);
        }

        .card-ujian {
            border: 2px solid #000;
            height: 97mm;
            position: relative;
            overflow: hidden;
            background: #fff;
            padding: 10px;
        }

        /* =========================
           HEADER SEKOLAH
        ========================== */

        .header-sekolah {
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            margin-bottom: 5px;
            position: relative;
            min-height: 70px;
        }

        /* Logo dibuat absolute supaya seperti
           "In Front Of Text" di Word */
        .logo-sekolah {
            width: 50px;
            height: 50px;
            object-fit: contain;

            position: absolute;
            left: 7%;
            top: 40%;
            transform: translate(-50%, -50%);
            z-index: 2;
        }

        .text-header {
            text-align: center;
            padding: 0 10px;
        }

        .nama-yayasan {
            font-size: 14px;
            font-weight: 700;
            line-height: 1.2;
        }

        .nama-sekolah {
            font-size: 13px;
            font-weight: 800;
            line-height: 1.2;
        }

        .sub-sekolah {
            font-size: 12px;
            line-height: 1.3;
        }

        .akreditasi {
            font-size: 12px;
            font-style: italic;
        }

        /* =========================
           JUDUL KARTU
        ========================== */

        .judul-kartu {
            text-align: center;
            margin-top: 6px;
            margin-bottom: 8px;
        }

        .judul-kartu h5 {
            font-size: 13px;
            font-weight: 800;
            margin-bottom: 3px;
            line-height: 1.3;
        }

        /* =========================
           DATA PESERTA
        ========================== */

        .data-peserta {
            width: 100%;
            font-size: 13px;
        }

        .data-peserta td {
            padding: 2px 0;
            vertical-align: top;
        }

        /* =========================
           FOOTER TTD
        ========================== */

        .footer-ttd {
            position: absolute;
            bottom: 10px;
            right: 10px;
            text-align: center;
            font-size: 13px;
            width: 160px;
        }

        .ttd-space {
            height: 42px;
        }

        @media print {

            body {
                background: white;
            }

            .a4-page {
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

        <div class="row-kartu">

            @if ($detailKartuUjian->isNotEmpty())

                @foreach ($detailKartuUjian as $s)
                    <div class="col-kartu">

                        <div class="card-ujian">

                            <div class="header-sekolah">

                                {{-- LOGO --}}
                                @if ($s->siswa && $s->siswa->sekolah && $s->siswa->sekolah->logo)
                                    <img src="{{ asset('storage/sekolah/' . $s->siswa->sekolah->logo) }}"
                                        class="logo-sekolah">
                                @else
                                    <img src="{{ asset('images/logo-default.png') }}" class="logo-sekolah">
                                @endif

                                @php
                                    $jenjang = strtoupper($s->siswa->sekolah->jenjang ?? '');

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

                                {{-- TEXT HEADER --}}
                                <div class="text-header">


                                    <div class="nama-sekolah">
                                        {{ $namaJenjang }}
                                    </div>
                                    <div class="nama-yayasan">
                                        {{ strtoupper($s->siswa->sekolah->nama_sekolah ?? 'YAYASAN') }}
                                    </div>

                                    <div class="sub-sekolah">
                                        {{ $s->siswa->sekolah->alamat ?? '' }}
                                    </div>

                                    <div class="akreditasi">
                                        {{ $s->siswa->sekolah->kabupaten_kota ?? '-' }},
                                        {{ $s->siswa->sekolah->provinsi ?? '-' }}
                                    </div>

                                </div>

                            </div>

                            {{-- JUDUL --}}
                            <div class="judul-kartu">

                                <h5>KARTU PESERTA UJIAN</h5>

                                <h5>
                                    {{ strtoupper($selectedUjian->nama_ujian ?? 'UJIAN') }}
                                </h5>

                                <h5>
                                    {{ strtoupper('TAHUN AJARAN ' . ($selectedUjian->tahunAjaran->tahun_ajaran ?? '') . ' ' . ($selectedUjian->tahunAjaran->semester ?? '')) }}
                                </h5>

                            </div>

                            {{-- DATA --}}
                            <table class="data-peserta">

                                <tr>
                                    <td width="65"><strong>NIS</strong></td>
                                    <td width="10">:</td>
                                    <td>{{ $s->siswa->nis ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Nama</strong></td>
                                    <td>:</td>
                                    <td>{{ $s->siswa->nama_siswa ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Kelas</strong></td>
                                    <td>:</td>
                                    <td>{{ $s->siswa->kelas->nama_kelas ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Ruangan</strong></td>
                                    <td>:</td>
                                    <td>{{ $s->ruangan ?? '-' }}</td>
                                </tr>

                            </table>

                            {{-- TTD --}}
                            <div class="footer-ttd">

                                {{ $s->siswa->sekolah->kabupaten_kota ?? 'Tasikmalaya' }},
                                {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}

                                <br>

                                Kepala Sekolah

                                <div class="ttd-space"></div>

                                <strong>
                                    {{ $s->siswa->sekolah->kepala_sekolah ?? '-' }}
                                </strong>

                                <br>

                                NIP. {{ $s->siswa->sekolah->nip_kepala_sekolah ?? '-' }}

                            </div>

                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-5">
                    Tidak ada data siswa ditemukan
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
