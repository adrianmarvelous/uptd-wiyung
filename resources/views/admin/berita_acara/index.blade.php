@extends('admin.index')

@section('content')
    <style>
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
    </style>

    <div class="card p-3">
        <h1>Berita Acara</h1>

        <div class="d-flex justify-content-end">
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Buat Berita Acara
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
                        <div class="modal-body">

                            {{-- NOP --}}
                            <label>NOP</label>
                            <div class="position-relative mb-3">
                                <input type="text" class="form-control search-input" id="nop" name="nop"
                                    placeholder="Cari NOP" autocomplete="off">
                                <div class="dropdown-list list-group d-none"></div>
                            </div>

                            {{-- Nama --}}
                            <label>Nama</label>
                            <div class="position-relative mb-3">
                                <input type="text" class="form-control search-input" id="nama" name="nama"
                                    placeholder="Cari Nama" autocomplete="off">
                                <div class="dropdown-list list-group d-none"></div>
                            </div>

                            {{-- Alamat --}}
                            <label>Alamat</label>
                            <div class="position-relative">
                                <input type="text" class="form-control search-input" id="alamat" name="alamat"
                                    placeholder="Cari Alamat" autocomplete="off">
                                <div class="dropdown-list list-group d-none"></div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button class="btn btn-primary">Selanjutnya</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>NOP</th>
                        <th>Wajib Pajak</th>
                        <th>Alamat</th>
                        <th>Narasi</th>
                        <th>Pegawai 1</th>
                        <th>Pegawai 2</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>

                            {{-- AKSI (mobile only) --}}
                            <td class="aksi-cell d-md-none">
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
                            </td>

                            {{-- NO (desktop only) --}}
                            <td class="d-none d-md-table-cell">
                                {{ $loop->iteration }}
                            </td>

                            <td data-label="NOP">{{ $item->wajibPajak->nop }}</td>
                            <td data-label="Nama">{{ $item->wajibPajak->nama }}</td>
                            <td data-label="Alamat">{{ $item->wajibPajak->alamat }}</td>
                            <td data-label="Narasi">{!! $item->narasi !!}</td>
                            <td data-label="Pegawai 1">{{ $item->pegawai1 ? $item->pegawai_1->nama_pegawai : '-' }}</td>
                            <td data-label="Pegawai 2">{{ $item->pegawai2 ? $item->pegawai_2->nama_pegawai : '-' }}</td>
                            <td data-label="Tanggal">{{ $item->created_at->format('d-m-Y') }}</td>


                            <td class="aksi-cell d-none d-md-table-cell">
                                <div class="dropdown">
                                    <button class="aksi-btn btn btn-primary" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="https://wa.me/{{ $item->telp }}" target="_blank"> <i class="bi bi-whatsapp"></i> Whatsapp</a></li>
                                        <li><a class="dropdown-item" href="{{ route('berita_acara.ba_pdf', $item->id) }}" target="_blank"> <i class="bi bi-file-pdf"></i> PDF</a></li>
                                        <li><a class="dropdown-item" href="{{ route('berita_acara.ba_pdf', $item->id) }}" target="_blank"> <i class="bi bi-pencil"></i> Edit</a></li>
                                        <li>
                                            <form method="POST" action="#">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item text-danger"><i class="bi bi-trash"></i> Hapus</button>
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
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            let cache = [];

            async function searchWP(keyword) {
                if (keyword.length < 2) return [];

                const res = await fetch(`{{ route('berita_acara.search') }}?q=${encodeURIComponent(keyword)}`);
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
                    data-alamat="${item.alamat}">
                    ${item[field]}
                </button>
            `);
                });

                container.classList.remove('d-none');
            }

            function fillAll(item) {
                document.getElementById('nop').value = item.nop;
                document.getElementById('nama').value = item.nama;
                document.getElementById('alamat').value = item.alamat;

                document.querySelectorAll('.dropdown-list').forEach(d => d.classList.add('d-none'));
            }

            function debounce(fn, delay = 400) {
                let t;
                return (...args) => {
                    clearTimeout(t);
                    t = setTimeout(() => fn(...args), delay);
                };
            }

            document.querySelectorAll('.search-input').forEach(input => {
                const dropdown = input.nextElementSibling;
                const field = input.id; // nop | nama | alamat

                const debounced = debounce(async () => {
                    const data = await searchWP(input.value);
                    cache = data;
                    renderDropdown(dropdown, data, field);
                });

                input.addEventListener('input', debounced);

                dropdown.addEventListener('click', e => {
                    const btn = e.target.closest('.list-group-item');
                    if (!btn) return;

                    fillAll({
                        nop: btn.dataset.nop,
                        nama: btn.dataset.nama,
                        alamat: btn.dataset.alamat
                    });
                });
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
