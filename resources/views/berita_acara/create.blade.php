@extends('index')

@section('content')
    <h1>{{ isset($berita) ? 'Edit Berita Acara' : 'Buat Berita Acara' }}</h1>

    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-end">

                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    {{ isset($berita) ? 'Edit Upload Berita Acara' : 'Upload Berita Acara' }}
                </button>

                <div class="modal fade" id="exampleModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title fw-bold">Upload Berita Acara</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('berita_acara.upload') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                @isset($berita)
                                    <input type="hidden" name="id" value="{{ $berita->id }}">
                                @endisset

                                {{-- Hidden NOP --}}
                                <input type="hidden" id="hidden_nop" name="nop"
                                    value="{{ old('nop', $berita->wajibPajak->nop ?? $nop) }}">

                                <div class="modal-body">
                                    {{-- File Upload --}}
                                    <label>Upload File</label>
                                    <input type="file" name="file" class="form-control"
                                        {{ isset($berita) ? '' : 'required' }} accept=".pdf">

                                    {{-- Show current uploaded file if exists --}}
                                    @isset($berita)
                                        @if ($berita->file_berita_acara)
                                            <div class="mt-2">
                                                <label class="fw-bold">File Saat Ini</label><br>
                                                <a href="{{ asset('storage/' . $berita->file_berita_acara) }}" target="_blank">
                                                    {{ basename($berita->file_berita_acara) }}
                                                </a>
                                            </div>
                                        @endif
                                    @endisset

                                    {{-- Petugas 1 --}}
                                    <div class="row mt-3">
                                        <div class="col-lg-3"><strong>Petugas 1</strong></div>
                                        <div class="col-lg-9">
                                            <select name="pegawai1" class="form-select" required>
                                                <option value="" disabled selected>Pilih Petugas 1</option>
                                                @foreach ($pegawai as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ old('pegawai1', $berita->pegawai1 ?? '') == $item->id ? 'selected' : '' }}>
                                                        {{ $item->nama_pegawai }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Petugas 2 --}}
                                    <div class="row mt-3">
                                        <div class="col-lg-3"><strong>Petugas 2</strong></div>
                                        <div class="col-lg-9">
                                            <select name="pegawai2" class="form-select">
                                                <option value="" disabled selected>Pilih Petugas 2</option>
                                                <option value="">Tidak ada</option>
                                                @foreach ($pegawai as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ old('pegawai2', $berita->pegawai2 ?? '') == $item->id ? 'selected' : '' }}>
                                                        {{ $item->nama_pegawai }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Modal Footer --}}
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($berita) ? 'Update File & Petugas' : 'Upload Berita Acara' }}
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

            </div>


            <form action="{{ route('berita_acara.approval_wajib_pajak') }}" method="POST">

                @csrf
                @isset($berita)
                    <input type="hidden" name="id" value="{{ $berita->id }}">
                @endisset


                {{-- NOP --}}
                <div class="row mb-3">
                    <div class="col-lg-2"><strong>NOP</strong></div>

                    <div class="col-lg-10 position-relative">
                        <input type="text" class="form-control search-input" id="nop"
                            value="{{ old('nop', $berita->nop ?? $nop) }}" autocomplete="off" required>

                        <div class="dropdown-list list-group d-none"></div>
                    </div>
                </div>


                {{-- Nama --}}
                <div class="row mb-3">
                    <div class="col-lg-2"><strong>Nama</strong></div>

                    <div class="col-lg-10 position-relative">
                        <input type="text" class="form-control search-input" id="nama"
                            value="{{ old('nama', $berita->wajibPajak->nama ?? $nama) }}" autocomplete="off" required>

                        <div class="dropdown-list list-group d-none"></div>
                    </div>
                </div>


                {{-- Alamat --}}
                <div class="row mb-3">
                    <div class="col-lg-2"><strong>Alamat</strong></div>

                    <div class="col-lg-10 position-relative">
                        <input type="text" class="form-control search-input" id="alamat"
                            value="{{ old('alamat', $berita->alamat ?? $alamat) }}" autocomplete="off" required>

                        <div class="dropdown-list list-group d-none"></div>
                    </div>
                </div>



                {{-- Hidden values used for submit --}}
                <input type="hidden" id="hidden_nop" name="nop" value="{{ $berita->nop ?? $nop }}">
                <input type="hidden" id="hidden_nama" name="nama" value="{{ $berita->nama ?? $nama }}">
                <input type="hidden" id="hidden_alamat" name="alamat" value="{{ $berita->alamat ?? $alamat }}">



                <div class="row mb-3">
                    <div class="col-lg-2"><strong>Nama Responden</strong></div>

                    <div class="col-lg-10">
                        <input type="text" name="nama_responden" class="form-control"
                            value="{{ old('nama_responden', $berita->nama ?? '') }}" required>
                    </div>
                </div>



                <div class="row mb-3">
                    <div class="col-lg-2"><strong>Nomer Whatsapp</strong></div>

                    <div class="col-lg-10">
                        <input type="number" name="telp" class="form-control"
                            value="{{ old('telp', $berita->telp ?? '') }}" placeholder="Awali dengan 62" required>
                    </div>
                </div>



                <div class="mb-3">
                    <textarea id="summernote" name="narasi">
                        {{ old('narasi', $berita->narasi ?? '') }}
                    </textarea>
                </div>



                <div class="row mt-3">
                    <div class="col-lg-2"><strong>Petugas 1</strong></div>

                    <div class="col-lg-10">

                        <select name="pegawai1" class="form-select" required>

                            <option value="" disabled selected>Pilih Petugas 1</option>

                            @foreach ($pegawai as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('pegawai1', $berita->pegawai1 ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_pegawai }}
                                </option>
                            @endforeach

                        </select>

                    </div>
                </div>



                <div class="row mt-3">
                    <div class="col-lg-2"><strong>Petugas 2</strong></div>

                    <div class="col-lg-10">

                        <select name="pegawai2" class="form-select">

                            <option value="" disabled>Pilih Petugas 2</option>
                            <option value="0">Tidak ada</option>

                            @foreach ($pegawai as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('pegawai2', $berita->pegawai2 ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_pegawai }}
                                </option>
                            @endforeach

                        </select>

                    </div>
                </div>



                <div class="d-flex justify-content-end mt-4">

                    <button type="submit" class="btn btn-primary">
                        {{ isset($berita) ? 'Update Berita Acara' : 'Masukan Tanda Tangan Wajib Pajak' }}
                    </button>

                </div>

            </form>

        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const jenis = "{{ $berita->wajibPajak->jenis ?? request()->route('jenis') }}";

            async function searchWP(keyword) {

                if (keyword.length < 2) return [];

                const res = await fetch(
                    `{{ route('berita_acara.search') }}?q=${encodeURIComponent(keyword)}&jenis=${jenis}`
                );

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

                document.getElementById('alamat').value = item.alamat;



                document.getElementById('hidden_nop').value = item.nop;
                document.getElementById('hidden_nama').value = item.nama;
                document.getElementById('hidden_alamat').value = item.alamat;



                document.querySelectorAll('.dropdown-list')
                    .forEach(d => d.classList.add('d-none'));

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
                const field = input.id;

                const debounced = debounce(async () => {

                    const data = await searchWP(input.value);

                    renderDropdown(dropdown, data, field);

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



            document.getElementById('nop').addEventListener('input', function() {
                document.getElementById('hidden_nop').value = this.value;
            });

            document.getElementById('nama').addEventListener('input', function() {
                document.getElementById('hidden_nama').value = this.value;
            });

            document.getElementById('alamat').addEventListener('input', function() {
                document.getElementById('hidden_alamat').value = this.value;
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
