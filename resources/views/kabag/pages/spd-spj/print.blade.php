<html>

<head>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
        crossorigin="anonymous"></script>
    <title>RINCIAN BIAYA PERJALANAN DINAS</title>
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
            border-top: 1px solid double black;
            vertical-align: middle;
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




    <div class = "rangkasurat" style="color: black">
        <table class="header" width = "100%">
            <tr>
                <td> <img src="{{ asset('assets/images/logo.png') }}" width="120px"> </td>
                <td style="width:  "></td>
                <td style="width:60%" class = "tengah">
                    <center>
                        <h5 style="line-height:50px;border:1px solid black;">RINCIAN BIAYA PERJALANAN DINAS</h5>
                    </center>

                </td>
                <td style="width:15%">
                </td>
                <td style="width:40%">
                    <table style="color: black">
                        <tr>
                            <td>Tahun Anggaran</td>
                            <td>:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>No. Bukti</td>
                            <td>:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>MAK</td>
                            <td>:</td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>
        @php
            date_default_timezone_set('Asia/Jakarta');
            $t = date('d-m-Y');
            $i = 1;
            $jumlah = 0;
        @endphp
        <div class="isi" style="font-size:12pt;margin-top:30px;line-height:1">
            <table style="color: black">
                <tr>
                    <td style="width:30%">Lampiran SPD Nomor</td>
                    <td style="width:5%">:</td>
                    <td style="width:65%">{{ $spj->spd->spd->surat->nomor_surat }}</td>
                </tr>
                <tr>
                    <td style="width:20%">Tanggal</td>
                    <td style="width:5%">:</td>
                    <td style="width:75%">
                        {{ $spj->spd->spd->created_at->translatedFormat('d F Y') }}</td>
                </tr>
            </table>
        </div>

        <div class="isi" style="font-size:12px;margin-top:30px;line-height:1">
            <table class="list" style="width:100%; color:black">
                <thead>
                    <tr>
                        <th class="th">Nomor</th>
                        <th class="th">Perincian Biaya</th>
                        <th class="th">Jumlah (Rp)</th>
                        <th class="th">Keterangan</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($spj->details as $detail)
                        <tr>
                            <td style="text-align:center;width:5%;border-right:1px solid black">{{ $loop->iteration }}
                            </td>
                            <td style="text-align:center;width:35%;border-right:1px solid black">
                                {{ $detail->perincian_biaya }}</td>
                            <td style="text-align:center;width:25;border-right:1px solid black">{{ $detail->nominal }}
                            </td>
                            <td style="text-align:center;width:35%">{{ $detail->keterangan }}</td>
                        </tr>
                    @endforeach
                    <tr style="height:50px">
                        <td style="border-right:1px solid black"></td>
                        <td style="border-right:1px solid black"></td>
                        <td style="border-right:1px solid black"></td>
                        <td style="border-right:1px solid black"></td>
                    </tr>
                    <tr>
                        <td style="border-right:1px solid black"></td>
                        <td style="border-right:1px solid black">Jumlah:</td>
                        <td style="text-align:center;width:25;height:20px;border-right:1px solid black;">
                            @php
                                $jumlah = number_format($spj->details->sum('nominal'), 0, ',', '.');
                            @endphp {{ $jumlah }}</td>
                        <td></td>
                    </tr>

                </tbody>

                <tfoot>
                    <tr>
                        @php
                            $terbilang = '';
                            $arr = [
                                '1' => 'Satu',
                                '2' => 'Dua',
                                '3' => 'Tiga',
                                '4' => 'Empat',
                                '5' => 'Lima',
                                '6' => 'Enam',
                                '7' => 'Tujuh',
                                '8' => 'Delapan',
                                '9' => 'Sembilan',
                            ];
                            $jumlah1 = explode('.', $jumlah);
                            $ja = count($jumlah1);

                            for ($i = 0; $i < $ja; $i++) {
                                $s = $ja - $i;
                                if ($ja == 3) {
                                    $spe = 'Juta';
                                } elseif ($ja == 2) {
                                    $spe = 'Ribu';
                                } else {
                                    $spe = '';
                                }
                                $angka = str_split($jumlah1[$i]);
                                $jank = count($angka);
                                for ($j = 0; $j < $jank; $j++) {
                                    $ss = $jank - $j;
                                    if ($angka[$j] != 0) {
                                        if ($ss == 3) {
                                            $terbilang = $terbilang . ' ' . $arr[$angka[$j]] . ' Ratus';
                                        } elseif ($ss == 2) {
                                            if ($angka[$j] == 1) {
                                                $terbilang = $terbilang . ' Sepuluh';
                                            } else {
                                                $terbilang = $terbilang . ' ' . $arr[$angka[$j]] . ' Puluh';
                                            }
                                        } elseif ($ss == 1) {
                                            $terbilang = $terbilang . ' ' . $arr[$angka[$j]];
                                        }
                                    }
                                }
                                if ($i != 1) {
                                    $terbilang = $terbilang . ' ' . $spe;
                                }
                            }
                            $terbilang = $terbilang . ' Rupiah';
                        @endphp
                        <td class="td" colspan="4" style="background-color: grey; color: black">Terbilang:
                            {{ $terbilang }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="isi" style="font-size:12px;margin-top:30px;line-height:1">
            <table style="width:100%; color: black">
                <thead>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Subang, {{ $spj->created_at->translatedFormat('d F Y') }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="width:5%"></td>
                        <td style="width:30%">Telah Dibayar Sejumlah</td>
                        <td style="width:30%">Telah Menerima Uang Sebesar</td>
                        <td style="width:30%"></td>
                    </tr>
                    <tr style="height: 30px">
                        <td style="width:5%"></td>
                        <td style="width:30%">{{ $spj->spd->uang_muka->nominal }}</td>
                        <td style="width:30%">{{ $spj->spd->uang_muka->nominal }}</td>
                        <td style="width:30%"></td>
                    </tr>
                    <tr style="height: 30px">
                        <td style="width:5%"></td>
                        <td style="width:30%">{{ $bendahara->karyawan->jabatan->nama }}</td>
                        <td style="width:30%">{{ auth()->user()->karyawan->jabatan->nama }}</td>
                        <td style="width:30%"></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr style="height: 50px">
                        <td style="width:5%"></td>
                        <td style="width:30%">{{ $bendahara->karyawan->nama }} <br>NIP
                            {{ $bendahara->karyawan->nip }}
                        </td>
                        <td style="width:30%">{{ Auth::user()->karyawan->nama }} <br>NIP
                            {{ Auth::user()->karyawan->nip }}</td>
                        <td style="width:30%"></td>
                    </tr>
                </thead>
            </table>
        </div>


        <div class="isi"
            style="font-size:12px;margin-top:0px;line-height:1;border-top:1px solid black;border-bottom:1px solid black">
            <table style="color: black">
                <tr>
                    <th colspan="4" style="height:10px"></th>
                </tr>
                <tr>
                    <th colspan="4">PERHITUNGAN SPD RAMPUNG</th>
                </tr>
                <tr>
                    <th colspan="4" style="height:20px"></th>
                </tr>
                <tr>
                    <td style="width:1%"></td>
                    <td style="width:20%">Ditetapkan sejumlah</td>
                    <td style="width:1%">:</td>
                    <td style="width:30%">{{ $jumlah }}</td>
                </tr>
                <tr>
                    <td style="width:1%"></td>
                    <td style="width:20%">Yang telah dibayar semula</td>
                    <td style="width:1%">:</td>
                    <td style="width:30%">{{ $spj->spd->uang_muka->nominal }}</td>
                </tr>
                <tr>
                    @php
                        $jumlah = str_replace('.', '', $jumlah);
                        $uangmuka = str_replace('.', '', $spj->spd->uang_muka->nominal);
                        if ($jumlah < $uangmuka) {
                            $lk = 'Lebih';
                            $sisa = $uangmuka - $jumlah;
                        } else {
                            $lk = 'Kurang';
                            $sisa = $jumlah - $uangmuka;
                        }
                        $sisa = number_format($sisa, 0, ',', '.');
                    @endphp
                    <td style="width:1%"></td>
                    <td style="width:20%">Sisa {{ $lk }}</td>
                    <td style="width:1%">:</td>
                    <td style="width:30%">{{ $sisa }}</td>
                </tr>
            </table>
            <table class="staff" width="100%" style="position: absolute; bottom:10px">
                <tr>
                    <td style="width:70%">

                    </td>
                    <td style="width: 30%">
                        <div>Mengetahui, </div>
                        <div>{{ $ppk->karyawan->jabatan->nama }} <br>
                            Politeknik Negeri Subang
                        </div>
                        <div style="height:100px;margin-top:10px">
                            @if ($ppk->karyawan->tte_file)
                                <img src="{{ $ppk->karyawan->tte() }}" alt="" class="img-fluid"
                                    style="max-height: 80px">
                            @endif
                        </div>
                        <div>
                            {{ $ppk->karyawan->nama }} <br>
                            NIP. {{ $ppk->karyawan->nip }}
                        </div>
                    </td>
                </tr>
            </table>
        </div>

    </div>






</body>

<script>
    $(document).ready(function() {
        window.print()
    });
</script>

</html>
