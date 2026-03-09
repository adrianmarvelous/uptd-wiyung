@extends('index')

@section('content')
    <h1>{{ isset($berita) ? 'Edit Berita Acara' : 'Buat Berita Acara' }}</h1>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('berita_acara.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-lg-2"><strong>NOP</strong></div>
                    <div class="col-lg-10">
                        <p>{{ $nop }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-2"><strong>Nama</strong></div>
                    <div class="col-lg-10">
                        <p>{{ $nama }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-2"><strong>Alamat</strong></div>
                    <div class="col-lg-10">
                        <p>{{ $alamat }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-2"><strong>Nomer Whatsapp</strong></div>
                    <div class="col-lg-10">
                        <p>{{ $telp }}</p>
                    </div>
                </div>

                <p>{!! $narasi !!}</p>

                <div class="row mt-3">
                    <div class="col-lg-2"><strong>Petugas 1</strong></div>
                    <div class="col-lg-10">
                        <p>{{ $pegawai1->nama_pegawai }}</p>
                    </div>
                </div>

                @isset($pegawai2)
                    <div class="row mt-3">
                        <div class="col-lg-2"><strong>Petugas 2</strong></div>
                        <div class="col-lg-10">
                            <p>{{ $pegawai2->nama_pegawai }}</p>
                        </div>
                    </div>
                @endisset


                {{-- SIGNATURE --}}
                <div class="mt-4">

                    <label class="fw-bold">Tanda Tangan Wajib Pajak</label>

                    {{-- Show saved signature --}}
                    @isset($berita)
                        @if ($berita->ttd_wajib_pajak)
                            <div class="mb-3">
                                <label class="fw-bold">Tanda Tangan Tersimpan</label><br>
                                <img src="{{ asset($berita->ttd_wajib_pajak) }}" style="border:1px solid #ccc; max-width:500px;">
                            </div>
                        @endif
                    @endisset

                    @isset($berita)
                    <p>Update Tanda Tangan</p>
                    <input type="hidden" name="id" value="{{ $berita->id }}">
                    @endisset
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <canvas id="signature-pad" width="500" height="200"
                            style="border:1px solid #ccc; max-width:100%;"></canvas>
                    </div>

                    <input type="hidden" name="ttd_wajib_pajak" id="ttd_wajib_pajak"
                        value="{{ $berita->ttd_wajib_pajak ?? '' }}">

                    <div class="mt-2">
                        <button type="button" class="btn btn-secondary btn-sm" id="clear-signature">
                            Clear Tanda Tangan
                        </button>
                    </div>

                </div>


                <div class="row mt-3">
                    <div class="col-lg-2"><strong>Nama Responden</strong></div>
                    <div class="col-lg-10">
                        <p>{{ $nama_responden }}</p>
                    </div>
                </div>


                <div class="d-flex justify-content-end mt-3">

                    <input type="hidden" name="nop" value="{{ $nop }}">
                    <input type="hidden" name="nama" value="{{ $nama }}">
                    <input type="hidden" name="nama_responden" value="{{ $nama_responden }}">
                    <input type="hidden" name="alamat" value="{{ $alamat }}">
                    <input type="hidden" name="telp" value="{{ $telp }}">
                    <input type="hidden" name="narasi" value="{{ $narasi }}">
                    <input type="hidden" name="pegawai1" value="{{ $pegawai1->id }}">
                    <input type="hidden" name="pegawai2" value="{{ $pegawai2->id ?? null }}">

                    <button type="submit" class="btn btn-primary">Simpan</button>

                </div>

            </form>

        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const canvas = document.getElementById('signature-pad');
            const ctx = canvas.getContext('2d');
            const clearBtn = document.getElementById('clear-signature');
            const input = document.getElementById('ttd_wajib_pajak');

            let drawing = false;

            function getPosition(e) {
                const rect = canvas.getBoundingClientRect();
                return {
                    x: e.clientX - rect.left,
                    y: e.clientY - rect.top
                };
            }


            canvas.addEventListener('mousedown', e => {
                drawing = true;
                const pos = getPosition(e);
                ctx.beginPath();
                ctx.moveTo(pos.x, pos.y);
            });


            canvas.addEventListener('mousemove', e => {
                if (!drawing) return;
                const pos = getPosition(e);
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();
            });


            canvas.addEventListener('mouseup', () => {
                drawing = false;
                saveSignature();
            });


            canvas.addEventListener('mouseleave', () => {
                drawing = false;
            });


            canvas.addEventListener('touchstart', e => {
                e.preventDefault();
                drawing = true;
                const touch = e.touches[0];
                const rect = canvas.getBoundingClientRect();
                ctx.beginPath();
                ctx.moveTo(touch.clientX - rect.left, touch.clientY - rect.top);
            });


            canvas.addEventListener('touchmove', e => {
                e.preventDefault();
                if (!drawing) return;
                const touch = e.touches[0];
                const rect = canvas.getBoundingClientRect();
                ctx.lineTo(touch.clientX - rect.left, touch.clientY - rect.top);
                ctx.stroke();
            });


            canvas.addEventListener('touchend', () => {
                drawing = false;
                saveSignature();
            });


            clearBtn.addEventListener('click', () => {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                input.value = '';
            });


            function saveSignature() {
                input.value = canvas.toDataURL('image/png');
            }


            ctx.lineWidth = 2;
            ctx.lineCap = 'round';


            {{-- Load saved signature into canvas --}}
            @if (isset($berita) && $berita->ttd_wajib_pajak)

                const savedSignature = "{{ $berita->ttd_wajib_pajak }}";

                const img = new Image();
                img.onload = function() {
                    ctx.drawImage(img, 0, 0);
                };
                img.src = savedSignature;
            @endif


        });
    </script>
@endsection
