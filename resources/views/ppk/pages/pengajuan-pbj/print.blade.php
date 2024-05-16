<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Disposisi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            display: flex;
            align-items: center;
        }

        .logo {
            width: 100px;
            /* Sesuaikan dengan ukuran logo Anda */
            margin-right: 20px;
        }

        .header-text {
            text-align: center;
        }

        .header-text h2 {
            font-size: 24px;
            margin: 0;
        }

        .header-text h1 {
            font-size: 36px;
            margin: 0;
        }

        .header-text h3 {
            font-size: 24px;
            margin: 0;
        }

        .header-text h4 {
            font-size: 16px;
            margin: 0;
        }

        .line {
            border-top: 3px solid black;
            margin-top: 20px;
            text-align: center;
        }

        .line2 {
            border-top: 3px solid black;
            margin-top: 20px;
        }

        .line3 {
            border-top: 3px solid black;
            margin-top: 20px;
            padding-left: 20px;
        }

        .line4 {
            border-top: 3px solid black;
            margin-top: 20px;
            padding-left: 20px;
        }

        .checkboxes {
            display: inline-block;
        }

        .checkboxes label {
            margin-right: 10px;
        }

        .checkboxes input[type="checkbox"] {
            margin-right: 5px;
        }

        .checkboxes-right {
            float: right;
        }

        .checkboxes-right label {
            margin-right: 10px;
        }

        .checkboxes-right input[type="checkbox"] {
            margin-right: 5px;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="header">
        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="logo">
        <div class="header-text">
            <h2>Kementrian Pendidikan, Kebudayaan, Riset, dan Teknologi</h2>
            <h1>Politeknik Negeri Subang</h1>
            <h3>Pejabat Pembuat Komitmen</h3>
            <h4>Jl. Brigjen Katamso No. 37, Dangdeur, Subang, Jawa Barat.</h4>
            <h4>Jl. Sukamulya, Kec. Cibogo, Kab. Subang, Jawa Barat.</h4>
        </div>
    </div>
    <div class="line">
        <h2>LEMBAR DISPOSISI</h2>
    </div>
    <div class="line2">
        <div class="checkboxes">
            <input type="checkbox" id="rahasia" name="rahasia" @if ($item->tipe_disposisi_2 === 'Terbatas Biasa') checked @endif>
            <label for="terbatas_rahasia">Terbatas Biasa</label>
            <input type="checkbox" id="rahasia" name="rahasia" @if ($item->tipe_disposisi_2 === 'Rahasia') checked @endif>
            <label for="rahasia">Rahasia</label>
            <input type="checkbox" id="terbatas_rahasia" name="terbatas_rahasia"
                @if ($item->tipe_disposisi_2 === 'Segera') checked @endif>
            <label for="segera">Segera</label>
            <input type="checkbox" id="segera" name="segera" @if ($item->tipe_disposisi_2 === 'Sangat Segera') checked @endif>
            <label for="sangat_segera">Sangat Segera</label>
        </div>
    </div>
    <div class="line3">
        <table>
            <tr>
                <td>No. Agenda</td>
                <td>:</td>
                <td>{{ $item->pengajuan_barang_jasa->nomor_agenda ?? '-' }}</td>
            </tr>
            <tr>
                <td>No. Surat</td>
                <td>:</td>
                <td>{{ $item->pengajuan_barang_jasa->nomor_surat ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tanggal Surat</td>
                <td>:</td>
                <td>{{ $item->pengajuan_barang_jasa->created_at->translatedFormat('d F Y') ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>Asal Surat</td>
                <td>:</td>
                <td>{{ $item->pengajuan_barang_jasa->karyawan->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td>:</td>
                <td>{{ $item->pengajuan_barang_jasa->perihal ?? '-' }}</td>
            </tr>
        </table>
    </div>
    <div class="line4">
        <table>
            <tr>
                <td>Diteruskan Kepada</td>
                <td>:</td>
            </tr>
            <tr>
                <td>
                    <div class="checkboxes-left">
                        <input type="checkbox" checked id="arsip" name="arsip">
                        <label for="arsip">{{ $item->teruskan2->jabatan->nama }}</label>
                    </div>
                </td>
            </tr>
        </table>
        <br>
        <div>
            <div>
                <td><b>Intruksi/informasi</b></td>
            </div>
            <div>
                <td>{{ $item->catatan_disposisi_2 ?? '-' }}</td>
            </div>
        </div>
    </div>
    <br>
    <br>
    <table class="staff" width="100%" style="position: absolute; bottom:10px">
        <tr>
            <td style="width:70%">
            </td>
            <td style="width: 30%">
                <div>{{ $item->pembuat2->jabatan->nama }} <br>
                    Politeknik Negeri Subang
                </div>
                <div style="height:100px;margin-top:10px">
                    @if ($item->pembuat2->tte_file)
                        <img src="{{ $item->pembuat2->tte() }}" alt="" class="img-fluid"
                            style="max-height: 80px">
                    @endif
                </div>
                <div>
                    {{ $item->pembuat2->nama }} <br>
                    NIP. {{ $item->pembuat2->nip }}
                </div>
            </td>
        </tr>
    </table>

</body>

</html>
