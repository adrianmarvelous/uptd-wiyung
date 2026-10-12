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
    {{-- <table>
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
    </table> --}}

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
        <td>: {{ optional($data->pegawaiSatu)->nama_pegawai ?? '-' }}</td>
    </tr>
    <tr>
        <td>Pegawai 2</td>
        <td>: {{ optional($data->pegawaiDua)->nama_pegawai ?? '-' }}</td>
    </tr> --}}
    </table>
    <h2 style="text-align: center;text-decoration:underline;font-weight:bold">BERITA ACARA PEMERIKSAAN</h2>
    <div>
        <p style="text-indent: 30px">Pada hari ini {{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('l') }}
            tanggal {{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('j F Y') }} telah diadakan pemeriksaan ditempat,
            dengan hasil sebagai berikut</p>
        <p style="text-indent: 30px">{!! nl2br(e($data->narasi)) !!}</p>
    </div>
    <table width="100%">
        <tr>
            <td style="width: 50%"></td>
            <td style="width: 50%;text-align:center">Surabaya,
                {{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('j F Y') }}</td>
        </tr>
        <tr>
            <td style="text-align: center">Mengetahui</td>
            <td></td>
        </tr>
        <tr>
            <td style="text-align: center">Wajib Pajak</td>
            <td style="text-align: center">Petugas Pemeriksa</td>
        </tr>
        <tr>
            <td style="text-align: center; vertical-align: top;">
                @php
                    // Nilai kolom disimpan sebagai "storage/ttd_wajib_pajak/xxx.png" (disk public),
                    // jadi di-resolve langsung ke storage_path() supaya tidak bergantung pada
                    // symlink public/storage — dan tidak error saat tanda tangan masih kosong.
                    $ttdPath = $data->ttd_wajib_pajak
                        ? storage_path('app/public/' . preg_replace('#^/?storage/#', '', $data->ttd_wajib_pajak))
                        : null;
                @endphp
                @if ($ttdPath && is_file($ttdPath))
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents($ttdPath)) }}" width="200">
                @endif
            </td>
            <td style="vertical-align: top;">
                <table width="100%">
                    <tr>
                        <td>
                            <span>1. {{ optional($data->pegawaiSatu)->nama_pegawai ?? '-' }}</span>
                        </td>
                        <td rowspan="2" style="text-align: center;">
                            @php $spesimen1 = public_path('spesimen/'.$data->pegawaiSatu->nip_nik.'.png'); @endphp
                            @if (file_exists($spesimen1))
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents($spesimen1)) }}" width="70">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            NIP. {{ optional($data->pegawaiSatu)->nip_nik ?? '-' }}
                        </td>
                    </tr>
                    @if ($data->pegawaiDua)
                    <tr>
                        <td>
                            2. {{ optional($data->pegawaiDua)->nama_pegawai ?? '-' }}
                        </td>
                        <td rowspan="2" style="text-align: center;">
                            @php $spesimen2 = public_path('spesimen/'.$data->pegawaiDua->nip_nik.'.png'); @endphp
                            @if (file_exists($spesimen2))
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents($spesimen2)) }}" width="70">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            NIP. {{ optional($data->pegawaiDua)->nip_nik ?? '-' }}
                        </td>
                    </tr>
                    @endif
                </table>
            </td>
        </tr>
        <tr>
            <td style="text-align: center">{{ $data->nama }}</td>
            <td></td>
        </tr>
    </table>

</body>

</html>
