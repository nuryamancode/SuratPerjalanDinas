<html>

<head>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
        crossorigin="anonymous"></script>
    <title>Kwitansi </title>
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
                    <h5 style="line-height:1px">KUITANSI/BUKTI PEMBAYARAN</h5>
                </td>
                <td style="width:20%">
                </td>
                <td style="width:30%">
                    <table style="color: black">
                        <tr>
                            <td>Tahun Anggaran</td>
                            <td>:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>No Bukti</td>
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
            $jumlah = 0;
            foreach ($item->details as $detail) {
                $tambahan = str_replace('.', '', $detail->nominal);

                $jumlah = $jumlah + $tambahan;
            }
            $jumlah = number_format($jumlah, 0, ',', '.');
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

        <div class="isi" style="font-size:12px;margin-top:0px;line-height:1">
            <table style="color: black">
                <tr>
                    <td style="width:20%">Sudah Terima Dari</td>
                    <td style="width:5%">:</td>
                    <td style="width:75%">Kuasa Pengguna Anggaran/Pembuat Komitmen Politeknik Negeri Subang</td>
                </tr>
                <tr>
                    <td style="width:20%">Jumlah Uang</td>
                    <td style="width:5%">:</td>
                    <td style="width:75%">

                        <input type="text" style="border:3px solid black;width:450px" value="{{ $jumlah }}">
                    </td>
                </tr>
                <tr>
                    <td style="width:20%">Terbilang</td>
                    <td style="width:5%">:</td>
                    <td style="width:75%">
                        <input type="text" style="border:3px solid black;width:450px;height:30px"
                            value="{{ $terbilang }}">
                    </td>
                </tr>
                <tr style="height:20px"></tr>
                <tr>
                    <td style="width:20%">Untuk Pembayaran</td>
                    <td style="width:5%">:</td>
                    <td style="width:75%">
                        <input type="text" style="border:none;width:450px;height:70px"
                            value="{{ $item->untuk_pembayaran }}">
                    </td>
                </tr>
            </table>
        </div>

        <div class="isi" style="font-size:12px;margin-top:2em;line-height:1">
            <table style="color: black">
                <tr style="width:100%">
                    <td style="width:55%">
                        <table style="width:100%;border:1px solid black;  color: black">
                            <tr style="width:100%">
                                <td style="width:40%">Setuju Dibebankan pada mata anggaran berkenaan</td>
                                <td style="width:40%">Tanggal,
                                    {{ $item->created_at->translatedFormat('d F Y') }}<br>Bendahara Pengeluaran</td>
                            </tr>
                            <tr style="vertical-align:top;">
                                <td>An Kuasa Pengguna Anggaran
                                    <br>
                                    Pejabat Pembuat Komitmen
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <div style="text-align: center;margin-right:40px">
                                        @if ($ppk->tte_file)
                                            <img src="{{ $ppk->tte() }}" style="height:70px; width:70px"
                                                alt="">
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div style="text-align: center;margin-right:40px">
                                        @if ($bendahara->tte_file)
                                            <img src="{{ $ppk->tte() }}" style="height:70px; width:70px"
                                                alt="">
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ $ppk->nama }} <br>NIP {{ $ppk->nip }}</td>
                                <td>{{ $bendahara->nama }} <br>NIP {{ $bendahara->nip }}</td>
                            </tr>
                            <tr style="width:100%;border:1px solid black;">
                                <td style="border-top:1px solid black;height:10px" colspan="2">Barang/Pekerjaan
                                    tersebut telah diterima/diselelsaikan dengan lengkap dengan baik <br><br><br><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="width:10%">

                    </td>
                    <td style="width:35%">
                        <table style="width:100%; color: black">
                            <tr style="width:100%">
                            </tr>
                            <tr style="height:25px;vertical-align:top;">
                            </tr>
                            <tr style="width:100%">
                                <td style="border-top: 1px solid black;" colspan="2">
                                    <center>
                                        <br>
                                        Nama Jelas, Tanda Tangan dan cap
                                    </center>
                                </td>
                            </tr>
                            {{-- <tr style="width:100%">
                             <td style="width:100%">
                                 <table style="width:100%">
                                   <tr  style="width:100%">
                                       <td colspan="2" style="width:100%">Barang/Pekerjaan tersebut telah diterima/diselelsaikan dengan lengkap dengan baik</td>
                                   </tr>
                                 </table>
                               </td>
                         </tr> --}}
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
