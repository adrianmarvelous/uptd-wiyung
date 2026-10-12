@extends('index')

@section('content')
    {{-- <style>
        @media (max-width: 768px) {

            table thead {
                display: none;
            }

            table {
                border-collapse: separate !important;
                border-spacing: 0;
            }

            /* CARD */
            table tr {
                display: block;
                position: relative;
                margin-bottom: 1rem;
                /* padding: 2.8rem 0.75rem 0.75rem; */
                border: 1px solid #75a1ff;
                /* border-radius: 12px; */
                background: #75a1ff;
            }

            table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 6px 8px;
                border: 1px solid #2b2b2b;
                color: #e5e5e5;
            }

            table td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #9ca3af;
            }

            /* ===== AKSI BUTTON (MENYATU) ===== */
            td.aksi-cell {
                /* position: absolute;
            top: 8px;
            right: 8px; */
                border: none !important;
                padding: 0;
                background: transparent;
                z-index: 10;
            }

            td.aksi-cell::before {
                content: "";
            }

            td.aksi-cell .aksi-btn {
                width: 36px;
                height: 36px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: none;
                /* 🔑 menyatu */
            }

            td.aksi-cell .aksi-btn:hover,
            td.aksi-cell .aksi-btn:active {
                background: #2f2f2f;
            }

            td.aksi-cell .aksi-btn i {
                font-size: 1.2rem;
            }

            /* sembunyikan kolom desktop */
            .d-md-table-cell {
                display: none !important;
            }
        }
    </style> --}}

    <div class="card p-3">
        <h1>Berita Acara</h1>

        <div class="d-flex justify-content-end">
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Buat Berita Acara {{ request()->route('jenis') == 'OP' ? 'PBJT' : 'PBB' }}
            </button>
        </div>

        <!-- MODAL -->
        <div class="modal fade" id="exampleModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Berita Acara Baru</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form action="{{ route('berita_acara.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="jenis" value="{{ request()->route('jenis') }}">
                        <div class="modal-body">

                            <p class="text-muted small mb-2">
                                Pilih wajib pajak yang sudah terdaftar dari daftar pencarian, atau isi NOP
                                baru beserta nama &amp; alamat untuk mendaftarkan wajib pajak baru.
                            </p>

                            {{-- NOP --}}
                            <label>NOP</label>
                            <div class="position-relative mb-3">
                                <input type="text" class="form-control search-input" id="nop" name="nop"
                                    placeholder="Cari NOP" autocomplete="off" required>
                                <div class="dropdown-list list-group d-none"></div>
                            </div>

                            {{-- Nama --}}
                            <label>Nama</label>
                            <div class="position-relative mb-3">
                                <input type="text" id="nama" class="form-control search-input" autocomplete="off"
                                    required>
                                <input type="hidden" id="nama_real" name="nama">
                                <div class="dropdown-list list-group d-none"></div>
                            </div>

                            {{-- Alamat --}}
                            <label>Alamat</label>
                            <div class="position-relative">
                                <input type="text" class="form-control search-input" id="alamat" name="alamat"
                                    placeholder="Cari Alamat" autocomplete="off" required>
                                <div class="dropdown-list list-group d-none"></div>
                            </div>

                            {{-- Status wajib pajak: terdaftar / baru --}}
                            <div id="wp-status" class="small fw-semibold mt-3"></div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button class="btn btn-primary">Selanjutnya</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <form method="GET" action="{{ route('berita_acara', ['jenis' => $jenis]) }}" class="mb-3">
            <div class="row g-2 align-items-center">
                <div class="col-md-5">
                    <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control"
                        placeholder="Cari NOP / Nama / Alamat / Narasi...">
                </div>
                <div class="col-md-3">
                    <input type="month" name="bulan" value="{{ $bulanFilter ?? '' }}" class="form-control"
                        title="Filter bulan & tahun (kosongkan untuk semua)">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Cari</button>
                    <a class="btn btn-outline-secondary"
                        href="{{ route('berita_acara', ['jenis' => $jenis, 'bulan' => 'all']) }}">Semua Bulan</a>
                    <a class="btn btn-secondary" href="{{ route('berita_acara', ['jenis' => $jenis]) }}">Reset</a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table" id="berita-acara-table">
                <thead class="table-primary">
                    <tr>
                        <th class="d-none d-md-table-cell">No</th>
                        <th class="d-none d-md-table-cell">NOP</th>
                        <th>Wajib Pajak</th>
                        <th class="d-none d-md-table-cell">Alamat</th>
                        <th class="d-none d-md-table-cell">Narasi</th>
                        <th class="d-none d-md-table-cell">Pegawai 1</th>
                        <th class="d-none d-md-table-cell">Pegawai 2</th>
                        <th class="d-none d-md-table-cell">Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>

                            {{-- AKSI (mobile only) --}}
                            {{-- <td class="aksi-cell d-md-none">
                                <div class="dropdown">
                                    <button class="aksi-btn" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item"  href="https://wa.me/{{ $item->telp }}" target="_blank"> <i class="bi bi-whatsapp"></i> Whatsapp</a></li>
                                        <li><a class="dropdown-item" href="{{ route('berita_acara.ba_pdf', $item->id) }}" target="_blank"> <i class="bi bi-file-pdf"></i> PDF</a></li>
                                        <li><a class="dropdown-item" href="{{ route('berita_acara.ba_pdf', $item->id) }}" target="_blank"> <i class="bi bi-pen"></i> Edit</a></li>
                                        <li>
                                            <form method="POST" action="#">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item text-danger"><i class="bi bi-trash"></i> Hapus</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td> --}}

                            {{-- NO (desktop only) --}}
                            <td class="d-none d-md-table-cell">
                                {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                            </td>

                            <td class="d-none d-md-table-cell">{{ $item->wajibPajak->nop }}</td>
                            <td data-label="Nama">{{ $item->wajibPajak->nama }}</td>
                            <td class="d-none d-md-table-cell">{{ $item->wajibPajak->alamat }}</td>
                            <td class="d-none d-md-table-cell">{!! nl2br(e($item->narasi_teks)) !!}</td>
                            <td class="d-none d-md-table-cell">{{ $item->pegawaiSatu ? $item->pegawaiSatu->nama_pegawai : '-' }}
                            </td>
                            <td class="d-none d-md-table-cell">{{ $item->pegawaiDua ? $item->pegawaiDua->nama_pegawai : '-' }}
                            </td>
                            <td class="d-none d-md-table-cell">{{ $item->created_at->format('d-m-Y') }}</td>


                            <td class="aksi-cell">
                                <div class="dropdown">
                                    <button class="aksi-btn btn btn-primary" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        {{-- <li><a class="dropdown-item" href="https://wa.me/{{ $item->telp }}?text={{ urlencode('Berita Acara Anda Disini http://127.0.0.1:8000/berita_acara/ba_pdf/'.$item->id) }}"
                                                target="_blank"> <i class="bi bi-whatsapp"></i> Whatsapp</a></li> --}}
                                        <li>
                                            <a class="dropdown-item" 
                                            href="{{ 'https://wa.me/' . $item->telp . '?text=' . urlencode('Berita Acara Anda Disini ' . ($item->file_berita_acara ? url('storage/' . $item->file_berita_acara) : route('berita_acara.ba_pdf', \App\Support\UrlId::encode($item->id)))) }}" 
                                            target="_blank">
                                                <i class="bi bi-whatsapp"></i> Whatsapp
                                            </a>
                                        </li>
                                        <li><a class="dropdown-item"
                                                href="{{ $item->file_berita_acara ? asset('storage/' . $item->file_berita_acara) : route('berita_acara.ba_pdf', \App\Support\UrlId::encode($item->id)) }}"
                                                target="_blank"><i class="bi bi-file-pdf"></i> PDF</a>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ route('berita_acara.edit', \App\Support\UrlId::encode($item->id)) }}"> <i class="bi bi-pencil"></i> Edit</a></li>
                                        <li>
                                            <form method="POST" action="#">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item text-danger"><i class="bi bi-trash"></i>
                                                    Hapus</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $data->links('pagination::bootstrap-5') }}
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            let cache = [];
            const jenis = "{{ request()->route('jenis') }}";
            async function searchWP(keyword) {
                if (keyword.length < 2) return [];

                const res = await fetch(
                    `{{ route('berita_acara.search') }}?q=${encodeURIComponent(keyword)}&jenis=${jenis}`);
                return await res.json();
            }

            function renderDropdown(container, data, field) {
                container.innerHTML = '';

                if (!data.length) {
                    container.classList.add('d-none');
                    return;
                }

                data.forEach(item => {
                    container.insertAdjacentHTML('beforeend', `
                <button type="button"
                    class="list-group-item list-group-item-action"
                    data-nop="${item.nop}"
                    data-nama="${item.nama}"
                    data-alamat="${item.alamat}"
                    data-jenis="${item.jenis}">
                    ${
                        field === 'nama'
                            ? (item.jenis !== 'pbb'
                                ? `${item.nama} - ${item.jenis}`
                                : item.nama)
                            : item[field]
                    }
                </button>
            `);
                });

                container.classList.remove('d-none');
            }

            function fillAll(item) {
                document.getElementById('nop').value = item.nop;
                document.getElementById('nama').value =
                    item.jenis !== 'pbb' ?
                    `${item.nama} - ${item.jenis}` :
                    item.nama;
                document.getElementById('nama_real').value = item.nama; 
                document.getElementById('alamat').value = item.alamat;

                setStatus(true);

                document.querySelectorAll('.dropdown-list').forEach(d => d.classList.add('d-none'));
            }

            // Tandai apakah user memilih wajib pajak terdaftar atau menginput baru.
            function setStatus(terdaftar) {
                const status = document.getElementById('wp-status');
                if (!status) return;

                status.className = 'small fw-semibold mt-3 ' + (terdaftar ? 'text-success' : 'text-primary');
                status.textContent = terdaftar
                    ? 'Wajib pajak terdaftar — data akan memakai data yang tersimpan.'
                    : 'Wajib pajak baru — akan didaftarkan otomatis saat berita acara disimpan.';
            }

            function clearStatus() {
                const status = document.getElementById('wp-status');
                if (!status) return;

                status.className = 'small fw-semibold mt-3';
                status.textContent = '';
            }

            function debounce(fn, delay = 400) {
                let t;
                return (...args) => {
                    clearTimeout(t);
                    t = setTimeout(() => fn(...args), delay);
                };
            }

            document.querySelectorAll('.search-input').forEach(input => {
                const dropdown = input.parentElement.querySelector('.dropdown-list');
                const field = input.id; // nop | nama | alamat

                const debounced = debounce(async () => {
                    const data = await searchWP(input.value);
                    cache = data;
                    renderDropdown(dropdown, data, field);

                    // NOP yang persis sama dengan data terdaftar => pakai data lama,
                    // selain itu akan didaftarkan sebagai wajib pajak baru.
                    if (field === 'nop') {
                        const nop = input.value.trim().toLowerCase();
                        if (nop.length < 2) {
                            clearStatus();
                        } else {
                            setStatus(data.some(item => item.nop.trim().toLowerCase() === nop));
                        }
                    }
                });

                input.addEventListener('input', debounced);

                dropdown.addEventListener('click', e => {
                    const btn = e.target.closest('.list-group-item');
                    if (!btn) return;

                    fillAll({
                        nop: btn.dataset.nop,
                        nama: btn.dataset.nama,
                        alamat: btn.dataset.alamat,
                        jenis: btn.dataset.jenis
                    });
                });
            });

            document.getElementById('nama').addEventListener('input', function () {
                document.getElementById('nama_real').value = this.value;
            });

            document.addEventListener('click', e => {
                if (!e.target.closest('.position-relative')) {
                    document.querySelectorAll('.dropdown-list')
                        .forEach(d => d.classList.add('d-none'));
                }
            });

        });
    </script>
@endsection
