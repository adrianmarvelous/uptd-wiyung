@extends('index')

@section('content')
    <div class="card">
        <h1 class="p-3">Petugas</h1>
        @php
            $now = now();
            $currentBulan = request('bulan', now()->month);
            $currentTahun = request('tahun', now()->year);
        @endphp

        <ul class="nav nav-tabs p-3">
            @for ($i = 1; $i <= 12; $i++)
                @php
                    $isFuture = $currentTahun > $now->year || ($currentTahun == $now->year && $i > $now->month);

                    $isActive = $i == $currentBulan;
                @endphp

                <li class="nav-item">
                    <a class="nav-link {{ $isActive ? 'active' : '' }} {{ $isFuture ? 'disabled text-muted' : '' }}"
                        @if (!$isFuture) href="{{ route('berita_acara.petugas', ['bulan' => $i, 'tahun' => $currentTahun]) }}"
                @else
                    href="#"
                    tabindex="-1"
                    aria-disabled="true" @endif>
                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                    </a>
                </li>
            @endfor
        </ul>

        <div class="table-responsive mt-3">
            <table class="table" id="basic-datatables">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pegawai as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->nama_pegawai }}</td>
                            <td>{{ $item->jumlah_berita_acara }}</td>
                            <td><a class="btn btn-primary"
                                    href="{{ route('berita_acara.petugas.detail', ['id' => $item->id, 'bulan' => now()->month, 'tahun' => now()->year]) }}">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
