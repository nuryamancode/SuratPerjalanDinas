<html>

<head>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
        crossorigin="anonymous"></script>
    <title> Surat Perintah Perjalanan Dinas </title>
    <style type= "text/css">
        * {
            margin: 0;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #fff
        }

        .rangkasurat {
            margin: auto;
            background-color: #fff;
            padding: 10px
        }

        .header {
            padding: 0px;
            margin-top: 0;
            line-height: 1.5;

        }

        .tengah {
            font-size: 12pt;
            line-height: 1.5;
        }

        .judul {
            text-align: center;
            line-height: 5px;
            font-size: 12px;
            margin-top: 1em;
        }

        .isi {
            font-size: 12px;
        }

        .list {
            margin-top: 1em;
        }

        .list,
        .th,
        .td {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 12pt;
            margin-top: 1.5em;
            margin-left: 0.4em;
            border-top: 1px solid double black
        }



        h6 {
            font-size: 12pt;
            font-weight: 400;
            line-height: 1.5;
        }

        h5 {
            font-size: 12pt;
            font-style: bold;
            line-height: 1.5;
        }

        .isian1 {
            height: 80px;
            border: 1px solid black;
        }
    </style>
</head>

<body>




    <div class = "rangkasurat">
        <table class="header" width = "100%" style="color: black">
            <tr>
                {{-- <td> <img src="{{asset('template')}}/dist/assets/images/logoPolsub.png" width="120px"> </td> --}}
                <td style="width:50%" class = "tengah">
                    <br>
                    <h5 style="line-height:1px">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET DAN TEKNOLOGI</h5>
                    <h5 style="margin-top:0.2em;margin-bottom:1em">POLITEKNIK NEGERI SUBANG</h5>
                </td>
                <td style="width:20%">
                </td>
                <td style="width:30%">
                    <table style="color: black">
                        <tr>
                            <td>Lembar Ke</td>
                            <td>:</td>
                            <td>1 (Satu)</td>
                        </tr>
                        <tr>
                            <td>Kode No</td>
                            <td>:</td>
                            <td>{{ $item->kode ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Nomor</td>
                            <td>:</td>
                            <td>{{ $surat->surat_perjalanan_dinas->surat->nomor_surat ?? '-' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>

        <div class="judul" style="margin-bottom:2em">
            <h4 style="font-weight:bold; font-size:12pt;">SURAT PERINTAH PERJALANAN DINAS</h4>
        </div>
        <div style="border-bottom : 1px solid black;margin-bottom:0px" class="garis"></div>
        <div class="isi" style="font-size:12px;margin-top:0px;line-height:1">

            <table class="list" style="color: black">
                <tr class="isian1" style="vertical-align: middle">
                    <td style="width:5%;border-left:1px solid white">1</td>
                    <td style="width:40%;border-right:1px solid black">Pejabat Berwenang yang memberi perintah</td>
                    <td style="width:2%">:</td>
                    <td colspan="3" style="width:40%;border-right:1px solid white">Pejabat Pembuat Komitmen
                        Politeknik Negeri Subang</td>
                </tr>
                <tr class="isian1" style="vertical-align: middle">
                    <td style="width:5%;vertical-align:right;border-left:1px solid white">2</td>
                    <td style="width:40%;border-right:1px solid black">Nama / NIP Pegawai yang melaksanakan Perjalanan
                        Dinas</td>
                    <td style="width:2%">:</td>
                    <td colspan="3" style="width:40%;border-right:1px solid white">
                        {{ $item->karyawan->nama }}/{{ $item->karyawan->nip }}</td>
                </tr>
                <tr class="isian1" style="vertical-align: middle">
                    <td style="width:5%;vertical-align:right;border-left:1px solid white">3</td>
                    <td style="width:40%;border-right:1px solid black">
                        <table style="color: black">
                            <tr>
                                <td>a.</td>
                                <td> Pangkat dan Golongan</td>
                            </tr>
                            <tr>
                                <td>b.</td>
                                <td> Jabatan/Instansi</td>
                            </tr>
                            <tr>
                                <td>c.</td>
                                <td> Tingkat Biaya Perjalanan Dinas</td>
                            </tr>
                        </table>
                    </td>
                    <td style="width:2%">:</td>
                    <td colspan="3" style="width:40%;border-right:1px solid white">
                        <table style="color: black">
                            <tr>
                                <td>a.</td>
                                <td> {{ $item->karyawan->golongan->nama }}</td>
                            </tr>
                            <tr>
                                <td>b.</td>
                                <td> {{ $item->karyawan->jabatan->nama }}</td>
                            </tr>
                            <tr>
                                <td>c.</td>
                                <td> {{ $item->tingkat_biaya }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="isian1" style="vertical-align: middle">
                    <td style="width:5%;vertical-align:right;border-left:1px solid white">4</td>
                    <td style="width:40%;border-right:1px solid black">Maksud Perjalanan Dinas</td>
                    <td style="width:2%">:</td>
                    <td colspan="3" style="width:40%;border-right:1px solid white">
                        {{ $item->maksud_perjalanan_dinas }}</td>
                </tr>
                <tr class="isian1" style="vertical-align: middle">
                    <td style="width:5%;vertical-align:right;border-left:1px solid white">5</td>
                    <td style="width:40%;border-right:1px solid black">Alat angkut yang dipergunakan</td>
                    <td style="width:2%">:</td>
                    <td colspan="3" style="width:40%;border-right:1px solid white">{{ $item->alat_angkut }}</td>
                </tr>
                <tr class="isian1" style="vertical-align: middle">
                    <td style="width:5%;vertical-align:right;border-left:1px solid white">3</td>
                    <td style="width:40%;border-right:1px solid black">
                        <table style="color: black">
                            <tr>
                                <td>a.</td>
                                <td> Tempat Berangkat</td>
                            </tr>
                            <tr>
                                <td>b.</td>
                                <td> Tempat Tujuan</td>
                            </tr>
                        </table>
                    </td>
                    <td style="width:2%">:</td>
                    <td colspan="3" style="width:40%;border-right:1px solid white">
                        <table style="color: black">
                            <tr>
                                <td>a.</td>
                                <td> {{ $item->tempat_berangkat }}</td>
                            </tr>
                            <tr>
                                <td>b.</td>
                                <td> {{ $item->tempat_tujuan }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="isian1" style="vertical-align: middle">
                    <td style="width:5%;vertical-align:right;border-left:1px solid white">7</td>
                    <td style="width:40%;border-right:1px solid black">
                        <table style="color: black">
                            <tr>
                                <td>a.</td>
                                <td> Lamanya perjalanan dinas</td>
                            </tr>
                            <tr>
                                <td>b.</td>
                                <td> Tanggal berangkat</td>
                            </tr>
                            <tr style="vertical-align:top;">
                                <td>c.</td>
                                <td> Tanggal harus kembali/tiba di tempat baru*</td>
                            </tr>
                        </table>
                    </td>
                    <td style="width:2%">:</td>
                    <td colspan="3" style="width:40%;border-right:1px solid white">
                        <table style="color: black">
                            <tr>
                                <td>a.</td>
                                <td> {{ $item->lama_perjalanan }}</td>
                            </tr>
                            <tr>
                                <td>b.</td>
                                <td> {{ $item->tanggal_berangkat }}</td>
                            </tr>
                            <tr>
                                <td>c.</td>
                                <td> {{ $item->tanggal_harus_kembali }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="isian1" style="vertical-align: middle;height:50px">
                    <td style="width:5%;border-left:1px solid white">8</td>
                    <td style="width:40%;border-right:1px solid black">Pengikut : Nama</td>
                    <td style="width:2%"></td>
                    <td style="width:20%;border-right:1px solid black;vertical-align: middle">Tanggal Lahir</td>
                    <td style="width:2%"></td>
                    <td style="width:20%;border-right:1px solid white;vertical-align: center">Keterangan</td>
                </tr>
                <tr class="isian1" style="vertical-align: middle">
                    <td style="width:5%;vertical-align:right;border-left:1px solid white"></td>
                    <td style="width:40%;border-right:1px solid black">
                        <table style="color: black">
                            {{-- @foreach ($pengikut as $item)
                                <tr>
                                    <td>1. {{ $item->nama }}</td>
                                </tr>
                            @endforeach --}}

                        </table>
                    </td>
                    <td style="width:2%"></td>
                    <td style="width:20%;border-right:1px solid black">
                        <table style="color: black">
                            {{-- @foreach ($pengikut as $item)
                                <tr>
                                    <td>1. {{ $item->ttl }}</td>
                                </tr>
                            @endforeach --}}

                        </table>
                    </td>
                    <td style="width:2%"></td>
                    <td style="width:20%;border-right:1px solid white">
                        <table style="color: black">
                            {{-- @foreach ($pengikut as $item)
                                <tr>
                                    <td>1. {{ $item->keterangan_u }}</td>
                                </tr>
                            @endforeach --}}

                        </table>
                    </td>
                </tr>
                <tr class="isian1" style="vertical-align: middle">
                    <td style="width:5%;vertical-align:right;border-left:1px solid white">9</td>
                    <td style="width:40%;border-right:1px solid black">Pembebanan Anggaran
                        <table style="color: black">
                            <tr>
                                <td>a.</td>
                                <td> Instansi</td>
                            </tr>
                            <tr>
                                <td>b.</td>
                                <td>Mata Anggaran Kegiatan</td>
                            </tr>
                        </table>
                    </td>
                    <td style="width:2%">:</td>
                    <td colspan="3" style="width:40%;border-right:1px solid white">
                        <br>
                        <table style="color: black">
                            <tr>
                                <td>a.</td>
                                <td> {{ $item->instansi }}</td>
                            </tr>
                            <tr>
                                <td>b.</td>
                                <td> {{ $item->mata_anggaran_kegiatan }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="isian1" style="vertical-align: middle">
                    <td style="width:5%;border-left:1px solid white">10</td>
                    <td style="width:40%;border-right:1px solid black">Keterangan lain lain</td>
                    <td style="width:2%">:</td>
                    <td colspan="3" style="width:40%;border-right:1px solid white">
                        {{ $item->keterangan_lain_lain }}</td>
                </tr>


            </table>
            @php
                date_default_timezone_set('Asia/Jakarta');
                $t = date('d-m-Y');
            @endphp
            <div style="float:right;margin-top:30px;width:40%" class="ttd">
                <table class="staff" width="100%" style="color: black">
                    <tr>
                        <td style="width: 35%">Dikeluarkan di</td>
                        <td style="width: 2%">:</td>
                        <td>{{ $item->dikeluarkandi }}</td>
                    </tr>
                    <tr>
                        <td>Pada Tanggal</td>
                        <td>:</td>
                        <td>{{ $t }}</td>
                    </tr>
                    <tr>
                        <td style="height:5spx"></td>
                    </tr>
                    <tr>
                        <td colspan="3">Pejabat Pembuat Komitmen <br> Politeknik Negeri Subang</td>
                    </tr>
                    <tr>
                        <td style="height:50px"></td>
                    </tr>
                    <tr>
                        <td colspan="3">{{ $ppk->nama }} <br>NIP {{ $ppk->nip }}</td>
                    </tr>

                </table>
            </div>





        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <div class="isi">
        <table class="list"
            style="width:100%;border-top:5px double black;border-bottom:5px double black; color :black">
            <tr class="isian1" style="width:100%;vertical-align:top">
                <td style="width:5%;border-left:1px solid white"></td>
                <td style="width:50%;border-left:1px solid white"></td>
                <td>
                    <table style="color: black">
                        <tr>
                            <td style="width: 5%">I</td>
                            <td style="width: 33%">Berangkat dari</td>
                            <td style="width: 30%">:</td>
                            <td>{{ $item->tempat_berangkat }};</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Ke</td>
                            <td>:</td>
                            <td>{{ $item->tempat_tujuan }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Pada tanggal</td>
                            <td>:</td>
                            <td>{{ $item->tanggal_berangkat }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" style="height:5px"></td>
                        </tr>
                        <tr style="width:30%">
                            <td></td>
                            <td colspan="2">Pejabat Pembuat Komitmen Politeknik Negeri Subang</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="height:50px"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="2">{{ $ppk->nama }} <br>NIP {{ $ppk->nip }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="isian1" style="width:100%;vertical-align:top;border-left:1px solid white;height:20px">
                <td colspan="2">
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:6%;border-left:1px solid white;vertical-align:top">II</td>
                            <td style="width:40%">Tiba di</td>
                            <td style="width:3%">:</td>
                            <td><input type="text" style="border:1px solid black;width:175px"
                                    value="{{ $item->tempat_tujuan }}"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:6%;border-left:1px solid white;vertical-align:top"></td>
                            <td style="width:40%">Pada tanggal</td>
                            <td style="width:3%">:</td>
                            <td><input type="text" style="border:1px solid black;width:175px"
                                    {{ $item->tempat_tujuan }}></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:6%;border-left:1px solid white;vertical-align:top"></td>
                            <td style="width:40%">Kepala</td>
                            <td style="width:3%">:</td>
                            <td><input type="text" style="border:1px solid black;width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:40%"></td>
                            <td style="width:3%"></td>
                            <td style="width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:30px">
                            <td style="width:40%"></td>
                            <td style="width:3%"></td>
                            <td style="width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:5%;border-left:1px solid white;vertical-align:top"></td>
                            <td style="width:40%"></td>
                            <td style="width:3%"></td>
                            <td style="width:175px">(.........................................)</td>
                        </tr>
                    </table>
                </td>
                <td colspan="2">
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:40%">Berangkat Dari</td>
                            <td style="width:3%">:</td>
                            <td><input type="text" style="border:1px solid black;width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:40%">Ke</td>
                            <td style="width:3%">:</td>
                            <td><input type="text" style="border:1px solid black;width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:40%">Pada tanggal</td>
                            <td style="width:3%">:</td>
                            <td><input type="text" style="border:1px solid black;width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:40%">Kepala</td>
                            <td style="width:3%">:</td>
                            <td><input type="text" style="border:1px solid black;width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:30px">
                            <td style="width:40%"></td>
                            <td style="width:3%"></td>
                            <td style="width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:5%;border-left:1px solid white;vertical-align:top"></td>
                            <td style="width:36%"></td>
                            <td style="width:1%"></td>
                            <td style="width:175px">(.........................................)</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="isian1" style="width:100%;vertical-align:top;border-left:1px solid white;height:20px">
                <td colspan="2">
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:6%;border-left:1px solid white;vertical-align:top">III</td>
                            <td style="width:40%">Tiba di</td>
                            <td style="width:3%">:</td>
                            <td><input type="text" style="border:1px solid black;width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:6%;border-left:1px solid white;vertical-align:top"></td>
                            <td style="width:40%">Pada tanggal</td>
                            <td style="width:3%">:</td>
                            <td><input type="text" style="border:1px solid black;width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:6%;border-left:1px solid white;vertical-align:top"></td>
                            <td style="width:40%">Kepala</td>
                            <td style="width:3%">:</td>
                            <td><input type="text" style="border:1px solid black;width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:40%"></td>
                            <td style="width:3%"></td>
                            <td style="width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:30px">
                            <td style="width:40%"></td>
                            <td style="width:3%"></td>
                            <td style="width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:5%;border-left:1px solid white;vertical-align:top"></td>
                            <td style="width:40%"></td>
                            <td style="width:3%"></td>
                            <td style="width:175px">(.........................................)</td>
                        </tr>
                    </table>
                </td>
                <td colspan="2">
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:40%">Berangkat Dari</td>
                            <td style="width:3%">:</td>
                            <td><input type="text" style="border:1px solid black;width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:40%">Ke</td>
                            <td style="width:3%">:</td>
                            <td><input type="text" style="border:1px solid black;width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:40%">Pada tanggal</td>
                            <td style="width:3%">:</td>
                            <td><input type="text" style="border:1px solid black;width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:40%">Kepala</td>
                            <td style="width:3%">:</td>
                            <td><input type="text" style="border:1px solid black;width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:30px">
                            <td style="width:40%"></td>
                            <td style="width:3%"></td>
                            <td style="width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:5%;border-left:1px solid white;vertical-align:top"></td>
                            <td style="width:36%"></td>
                            <td style="width:1%"></td>
                            <td style="width:175px">(.........................................)</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="isian1" style="width:100%;vertical-align:top;border-left:1px solid white;height:20px">
                <td colspan="2">
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:6%;border-left:1px solid white;vertical-align:top">IV</td>
                            <td style="width:40%">Tiba di</td>
                            <td style="width:3%">:</td>
                            <td><input type="text" style="border:1px solid black;width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:6%;border-left:1px solid white;vertical-align:top"></td>
                            <td style="width:40%">Pada tanggal</td>
                            <td style="width:3%">:</td>
                            <td><input type="text" style="border:1px solid black;width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:6%;border-left:1px solid white;vertical-align:top"></td>
                            <td style="width:40%">Kepala</td>
                            <td style="width:3%">:</td>
                            <td><input type="text" style="border:1px solid black;width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:40%"></td>
                            <td style="width:3%"></td>
                            <td style="width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:30px">
                            <td style="width:40%"></td>
                            <td style="width:3%"></td>
                            <td style="width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:5%;border-left:1px solid white;vertical-align:top"></td>
                            <td style="width:40%"></td>
                            <td style="width:3%"></td>
                            <td style="width:175px">(.........................................)</td>
                        </tr>
                    </table>
                </td>
                <td colspan="2">
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:40%">Berangkat Dari</td>
                            <td style="width:3%">:</td>
                            <td><input type="text" style="border:1px solid black;width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:40%">Ke</td>
                            <td style="width:3%">:</td>
                            <td><input type="text" style="border:1px solid black;width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:40%">Pada tanggal</td>
                            <td style="width:3%">:</td>
                            <td><input type="text" style="border:1px solid black;width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:40%">Kepala</td>
                            <td style="width:3%">:</td>
                            <td><input type="text" style="border:1px solid black;width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:30px">
                            <td style="width:40%"></td>
                            <td style="width:3%"></td>
                            <td style="width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:5%;border-left:1px solid white;vertical-align:top"></td>
                            <td style="width:36%"></td>
                            <td style="width:1%"></td>
                            <td style="width:175px">(.........................................)</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="isian1" style="width:100%;vertical-align:top;border-left:1px solid white;height:20px">
                <td colspan="2">
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:6%;border-left:1px solid white;vertical-align:top">V</td>
                            <td style="width:40%">Tiba kembali di</td>
                            <td style="width:3%">:</td>
                            <td><input type="text" style="border:1px solid black;width:175px"></td>
                        </tr>
                    </table>
                    <table style="color: black">
                        <tr style="width:5%;border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:6%;border-left:1px solid white;vertical-align:top"></td>
                            <td style="width:40%">Pada tanggal</td>
                            <td style="width:3%">:</td>
                            <td><input type="text" style="border:1px solid black;width:175px"></td>
                        </tr>
                    </table>
                </td>
                <td colspan="2">
                    Telah diperiksa dengan keterangan bahwa perjalanan tersebut atas perintahnya dan semata-mata untuk
                    kepentingan jabatan dalam waktu sesingkat-singkatnya
                </td>
            </tr>

            <tr class="isian1" style="width:100%;vertical-align:top;border-left:1px solid white;height:150px">
                <td style="width:40%" colspan="2">
                    <table style="width:100%; color: black">
                        <tr style="border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:20%"></td>
                            <td style="width:40%">Pejabat Pembuat Komitmen Politeknik Negeri Subang</td>
                            <td style="width:20%"></td>
                        </tr>
                        <tr style="border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="height:65px" colspan="3"></td>
                        </tr>
                        <tr style="border-left:1px solid white;vertical-align:top;height:35px">
                            <td style="width:20%"></td>
                            <td style="width:40%">{{ $ppk->nama }} <br>NIP {{ $ppk->nip }}</td>
                            <td style="width:20%"></td>
                        </tr>

            </tr>

        </table>
        </td>
        <td colspan="2" style="width:60%">
            <table style="width:100%; color : black">
                <tr style="border-left:1px solid white;vertical-align:top;height:35px">
                    <td style="width:10%"></td>
                    <td style="width:50%">Pejabat Pembuat Komitmen Politeknik Negeri Subang</td>
                    <td style="width:10%"></td>
                </tr>
                <tr style="border-left:1px solid white;vertical-align:top;height:35px">
                    <td style="height:65px" colspan="3"></td>
                </tr>
                <tr style="border-left:1px solid white;vertical-align:top;height:35px">
                    <td style="width:0%"></td>
                    <td style="width:60%">{{ $ppk->nama }} <br>NIP {{ $ppk->nip }}</td>
                    <td style="width:10%"></td>
                </tr>
            </table>
        </td>
        </tr>
        </table>
    </div>



</body>

<script>
    $(document).ready(function() {
        window.print()
    });
</script>

</html>
