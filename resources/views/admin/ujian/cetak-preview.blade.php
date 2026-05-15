<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Preview Soal Ujian</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:"Times New Roman", serif;
            font-size:18px;
            color:#000;
            line-height:1.5;
            background:#fff;
            margin:40px;
        }

        /* =========================
           KOP SURAT
        ==========================*/

        .kop-surat{
            width:100%;
            margin-bottom:15px;
        }

        .kop-surat table{
            width:100%;
        }

        .logo{
            width:90px;
            text-align:center;
            vertical-align:top;
        }

        .logo img{
            width:75px;
            height:auto;
        }

        .header-text{
            text-align:center;
        }

        .header-text .baris1{
            font-size:24px;
            font-weight:bold;
            text-transform:uppercase;
        }

        .header-text .baris2{
            font-size:22px;
            font-weight:bold;
            text-transform:uppercase;
        }

        .header-text .baris3{
            font-size:28px;
            font-weight:bold;
            text-transform:uppercase;
        }

        .header-text .alamat{
            font-size:16px;
            margin-top:5px;
        }

        .garis1{
            border:2px solid #000;
            margin-top:10px;
            margin-bottom:1px;
        }

        .garis2{
            border:1px solid #000;
        }

        /* =========================
           JUDUL
        ==========================*/

        .judul{
            text-align:center;
            margin-top:5px;
            margin-bottom:15px;
        }

        .judul h1{
            font-size:32px;
            margin-bottom:2px;
        }

        .judul h2{
            font-size:24px;
            font-weight:bold;
        }

        /* =========================
           IDENTITAS
        ==========================*/

        .identitas{
            width:100%;
            margin-bottom:20px;
            font-size:20px;
        }

        .identitas td{
            padding:2px 0;
            vertical-align:top;
        }

        .petunjuk{
            text-align:center;
            margin-top:10px;
            margin-bottom:20px;
            font-size:22px;
        }

        .instruksi{
            font-size:20px;
            margin-bottom:15px;
        }

        /* =========================
           SOAL
        ==========================*/

        .soal-container{
            width:100%;
        }

        .soal-item{
            margin-bottom:8px;
            page-break-inside:avoid;
        }

        .soal-text{
            font-size:20px;
            text-align:justify;
        }

        .gambar-soal{
            margin-top:10px;
            margin-bottom:10px;
        }

        .gambar-soal img{
            max-width:250px;
            height:auto;
        }

        .opsi{
            margin-left:30px;
            columns:2;
            column-gap:50px;
        }

        .opsi div{
            break-inside:avoid;
        }

        /* =========================
           PRINT
        ==========================*/

        @media print{

            @page{
                size:A4;
                margin:15mm;
            }

            body{
                margin:0;
            }

            .soal-item{
                page-break-inside:avoid;
            }

        }

    </style>

</head>
<body>

    <!-- =========================
         HEADER
    ========================== -->

    <div class="kop-surat">

        <table>
            <tr>

                <td class="logo">
                    <img src="{{ asset('logo/logo-kiri.png') }}">
                </td>

                <td class="header-text">

                    <div class="baris1">
                        PEMERINTAH KABUPATEN BARITO UTARA
                    </div>

                    <div class="baris2">
                        DINAS PENDIDIKAN
                    </div>

                    <div class="baris3">
                        SEKOLAH DASAR NEGERI 1 NIHAN HILIR
                    </div>

                    <div class="alamat">
                        Alamat : Desa Nihan Hilir Gg. Pusara RT.04 Kode Pos 73852
                        <br>
                        Email : sdn1nihanhilir@gmail.com
                    </div>

                </td>

                <td class="logo">
                    <img src="{{ asset('logo/logo-kanan.png') }}">
                </td>

            </tr>
        </table>

        <hr class="garis1">
        <hr class="garis2">

    </div>

    <!-- =========================
         JUDUL UJIAN
    ========================== -->

    <div class="judul">

        <h1>SOAL UJIAN SEKOLAH</h1>
        <h2>
            {{ strtoupper($ujian->jenis_ujian) }}
            <br>
            TAHUN PELAJARAN
            {{ $ujian->tahunPelajaran->tahun_ajaran }}
        </h2>

    </div>

    <!-- =========================
         IDENTITAS
    ========================== -->

    <table class="identitas">

        <tr>
            <td width="220">Mata Pelajaran</td>
            <td width="20">:</td>
            <td>{{ $ujian->mapel->nama_mapel }}</td>
        </tr>

        <tr>
            <td>Hari / Tanggal</td>
            <td>:</td>
            <td>
                {{ $ujian->tanggal_ujian
                    ? $ujian->tanggal_ujian->format('d F Y')
                    : '-' }}
            </td>
        </tr>

        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>............................................................</td>
        </tr>

        <tr>
            <td>NISN</td>
            <td>:</td>
            <td>............................................................</td>
        </tr>

    </table>

    <div class="petunjuk">
        <b>*SELAMAT MENGERJAKAN*</b>
    </div>

    <div class="instruksi">
        <b>
            I. Berilah tanda silang (X) pada salah satu jawaban
            a, b, c, atau d yang paling tepat !!
        </b>
    </div>

    <!-- =========================
         DAFTAR SOAL
    ========================== -->

    <div class="soal-container">

        @foreach($ujian->detailUjians as $index => $soal)

            <div class="soal-item">

                <!-- SOAL -->
                <div class="soal-text">

                    <b>{{ $index + 1 }}.</b>

                    {!! $soal->soal !!}

                </div>

                <!-- GAMBAR -->
                @if($soal->gambar_soal)

                    <div class="gambar-soal">

                        <img
                            src="{{ asset('storage/' . $soal->gambar_soal) }}"
                            alt="gambar soal"
                        >

                    </div>

                @endif

                <!-- PILIHAN GANDA -->
                @if($soal->tipe_soal == 'pilihan_ganda')

                    <div class="opsi">

                        @if($soal->opsi_a)
                            <div>a. {{ $soal->opsi_a }}</div>
                        @endif

                        @if($soal->opsi_b)
                            <div>b. {{ $soal->opsi_b }}</div>
                        @endif

                        @if($soal->opsi_c)
                            <div>c. {{ $soal->opsi_c }}</div>
                        @endif

                        @if($soal->opsi_d)
                            <div>d. {{ $soal->opsi_d }}</div>
                        @endif

                        @if($soal->opsi_e)
                            <div>e. {{ $soal->opsi_e }}</div>
                        @endif

                    </div>

                @endif

            </div>

        @endforeach

    </div>

</body>
</html>