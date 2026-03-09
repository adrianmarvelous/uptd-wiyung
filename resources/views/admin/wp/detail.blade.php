@extends('index')

@section('content')
    <div class="card p-3">
        <h1>
            Detail {{ $wp->nama }} —
            {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') }}
        </h1>

        <div class="table-responsive">
            <table class="table" id="basic-datatables">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Object Pajak</th>
                        <th>Nama</th>
                        <th>Narasi</th>
                        <th>Telp</th>
                        <th>Tanggal</th>
                        <th>Petugas 1</th>
                        <th>Petugas 2</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->wajibPajak->nama }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{!! $item->narasi !!}</td>
                            <td>{{ $item->telp }}</td>
                            <td>{{ $item->created_at->format('d-M-Y') }}</td>
                            <td>{{ $item->pegawaiSatu->nama_pegawai }}</td>
                            <td>{{ $item->pegawaiDua ? $item->pegawaiDua->nama_pegawai : '-' }}</td>
                            <td><a class="btn btn-danger" href="{{ $item->file_berita_acara ? asset('storage/' . $item->file_berita_acara) : route('berita_acara.ba_pdf', $item->id) }}"><i class="bi bi-file-pdf"></i></a></td>
                            {{-- <td>{{ $item->wajibPajak->jumlah_berita_acara }}</td>
                            <td><a class="btn btn-primary" href="{{ route('berita_acara.detail', $item->id) }}">Detail</a></td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
