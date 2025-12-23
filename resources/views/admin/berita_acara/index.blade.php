@extends('admin.index')


@section('content')
    <div class="card">
        <h1>Berita Acara</h1>
        <div class="d-flex justify-content-end">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Buat Berita Acara
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold" id="exampleModalLabel">Berita Acara Baru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                {{-- <span aria-hidden="true">&times;</span> --}}
                            </button>
                        </div>
                        <form action="{{ route('berita_acara.create') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <label>Cari NOP</label>
                                <input type="text" class="form-control" name="nop" id="nop" list="list-nop">

                                <datalist id="list-nop"></datalist>

                                <label class="mt-3">Cari Nama</label>
                                <input type="text" class="form-control" name="nama" id="nama" list="list-nama">

                                <datalist id="list-nama"></datalist>

                                <label class="mt-3">Cari Alamat</label>
                                <input type="text" class="form-control" name="alamat" id="alamat" list="list-alamat">

                                <datalist id="list-alamat"></datalist>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Tutup
                                </button>
                                <button type="submit" class="btn btn-primary">Selanjutnya</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NOP</th>
                        <th>Wajib Pajak</th>
                        <th>Alamat</th>
                        <th>Narasi</th>
                        <th>Pegawai 1</th>
                        <th>Pegawai 2</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    @php
                        dd($item->pegawai1)
                    @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->wajibPajak->nop }}</td>
                            <td>{{ $item->wajibPajak->nama }}</td>
                            <td>{{ $item->wajibPajak->alamat }}</td>
                            <td>{{ $item->narasi }}</td>
                            <td>{{ $item->pegawai1 ? $item->pegawai1->nama_pegawai : '-' }}</td>
                            <td>{{ $item->pegawai2 ? $item->pegawai2->nama_pegawai : '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            let wpCache = [];

            async function fetchWajibPajak(keyword) {
                if (keyword.length < 2) return;

                try {
                    const response = await fetch(
                        `{{ route('berita_acara.search') }}?q=${encodeURIComponent(keyword)}`
                    );

                    const data = await response.json();
                    wpCache = data;

                    renderDatalist(data);
                } catch (error) {
                    console.error('Search error:', error);
                }
            }

            function renderDatalist(data) {
                const listNop = document.getElementById('list-nop');
                const listNama = document.getElementById('list-nama');
                const listAlamat = document.getElementById('list-alamat');

                listNop.innerHTML = '';
                listNama.innerHTML = '';
                listAlamat.innerHTML = '';

                data.forEach(item => {
                    listNop.insertAdjacentHTML('beforeend',
                        `<option value="${item.nop}"></option>`
                    );
                    listNama.insertAdjacentHTML('beforeend',
                        `<option value="${item.nama}"></option>`
                    );
                    listAlamat.insertAdjacentHTML('beforeend',
                        `<option value="${item.alamat}"></option>`
                    );
                });
            }

            function autoFill(value) {
                const wp = wpCache.find(item =>
                    item.nop === value ||
                    item.nama === value ||
                    item.alamat === value
                );

                if (!wp) return;

                document.getElementById('nop').value = wp.nop;
                document.getElementById('nama').value = wp.nama;
                document.getElementById('alamat').value = wp.alamat;
            }

            function debounce(fn, delay = 400) {
                let timeout;
                return (...args) => {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => fn(...args), delay);
                };
            }

            const debouncedSearch = debounce(fetchWajibPajak);

            ['nop', 'nama', 'alamat'].forEach(id => {
                const input = document.getElementById(id);

                input.addEventListener('input', e => {
                    debouncedSearch(e.target.value);
                    autoFill(e.target.value);
                });

                input.addEventListener('change', e => {
                    autoFill(e.target.value);
                });
            });

        });
    </script>
@endsection
