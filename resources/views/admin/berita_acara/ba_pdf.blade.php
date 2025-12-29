<!DOCTYPE html>
<html>

<head>
    <title>Berita Acara</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 6px;
            vertical-align: top;
        }
    </style>
</head>

<body>
    <table>
        <tr width="100%">
            <td width="30%" style="text-align: center;font-weight:bold">PEMERINTAH KOTA SURABAYA</td>
            <td width="30%"></td>
            <td width="10%">Wilayah</td>
            <td width="5%">:</td>
            <td width="20%">.......................................</td>
        </tr>
        <tr width="100%">
            <td width="30%" style="text-align: center;font-weight:bold">BADAN PENDAPATAN DAERAH</td>
            <td width="30%"></td>
            <td width="10%">Kecamatan</td>
            <td width="5%">:</td>
            <td width="20%">.......................................</td>
        </tr>
        <tr width="100%">
            <td width="30%" style="text-align: center;font-weight:bold">Jl. Jimerto 25 - 27</td>
            <td width="30%"></td>
            <td width="10%">Kelurahan</td>
            <td width="5%">:</td>
            <td width="20%">.......................................</td>
        </tr>
        <tr width="100%">
            <td width="30%" style="text-align: center"></td>
            <td width="30%"></td>
            <td width="10%"></td>
        </tr>
    </table>

    <h2 style="text-align: center;text-decoration:underline;font-weight:bold">LAMPIRAN: HASIL PEMERIKSAAN LAPANGAN</h2>

    <table>
        <tr>
            <td width="15%">NOP</td>
            <td>: {{ $data->wajibPajak->nop }}</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>: {{ $data->wajibPajak->nama }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $data->wajibPajak->alamat }}</td>
        </tr>
        {{-- <tr>
        <td>Narasi</td>
        <td>: {!! $data->narasi !!}</td>
    </tr>
    <tr>
        <td>Pegawai 1</td>
        <td>: {{ optional($data->pegawai_1)->nama_pegawai ?? '-' }}</td>
    </tr>
    <tr>
        <td>Pegawai 2</td>
        <td>: {{ optional($data->pegawai_2)->nama_pegawai ?? '-' }}</td>
    </tr> --}}
    </table>
    <h2 style="text-align: center;text-decoration:underline;font-weight:bold">BUKTI PEMERIKSAAN</h2>
    <div>
        <p style="text-indent: 30px">Pada hari ini {{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('l') }}
            tanggal {{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('j F Y') }} jam
            {{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('H:i') }} telah diadakan pemeriksaan ditempat,
            dengan hasil sebagai berikut</p>
        <p style="text-indent: 30px">{!! $data->narasi !!}</p>
    </div>
    <table width="100%">
        <tr>
            <td style="width: 50%"></td>
            <td style="width: 50%;text-align:center">Surabaya,
                {{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('j F Y') }}</td>
        </tr>
        <tr>
            <td style="text-align: center">Menegtahui</td>
            <td></td>
        </tr>
        <tr>
            <td style="text-align: center">Wajib Pajak</td>
            <td style="text-align: center">Petugas Pemeriksa</td>
        </tr>
        <tr>
            <td style="text-align: center"></td>
            <td>
                <div style="display:flex; justify-content:flex-end; gap:10px;">
                    <span>1. {{ optional($data->pegawai_1)->nama_pegawai ?? '-' }}</span>
                    <span>(..........)</span>
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align: center"></td>
            <td>
                NIP. {{ optional($data->pegawai_1)->nip_nik ?? '-' }}
            </td>
        </tr>

        <tr>
            <td style="text-align: center">
                <img src="{{ public_path($data->ttd_wajib_pajak) }}" width="200">
            </td>
            <td>
                @if ($data->pegawai_2)
                    <div style="display:flex; justify-content:flex-end; gap:10px;">
                        <span>2. {{ optional($data->pegawai_2)->nama_pegawai ?? '-' }}</span>
                        <span>(..........)</span>
                    </div>
                @endif
            </td>
        </tr>
        <tr>
            <td style="text-align: center">{{ $data->nama }}</td>
            <td>
                @if ($data->pegawai_2)
                    NIP. {{ optional($data->pegawai_2)->nip_nik ?? '-' }}
                @endif
            </td>
        </tr>

    </table>

</body>

</html>
