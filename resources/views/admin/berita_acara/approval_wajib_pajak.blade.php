@extends('admin.index')


@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h1>Buat Berita Acara</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('berita_acara.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-2">
                        <strong>
                            <p>NOP</p>
                        </strong>
                    </div>
                    <div class="col-lg-10">
                        <p>{{ $nop }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2 font-weight-bold">
                        <strong>
                            <p>Nama</p>
                        </strong>
                    </div>
                    <div class="col-lg-10">
                        <p>{{ $nama }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2 font-weight-bold">
                        <strong>
                            <p>Alamat</p>
                        </strong>
                    </div>
                    <div class="col-lg-10">
                        <p>{{ $alamat }}</p>
                    </div>
                </div>
                <p>{!! $narasi !!}</p>
                <div class="row mt-3">
                    <div class="col-lg-2 font-weight-bold">
                        <p>Petugas 1</p>
                    </div>
                    <div class="col-lg-10">
                        <p>{{ $pegawai1->nama_pegawai }}</p>
                    </div>
                </div>
                @isset($pegawai2)
                    <div class="row mt-3">
                        <div class="col-lg-2 font-weight-bold">
                            <p>Petugas 2</p>
                        </div>
                        <div class="col-lg-10">
                            <p>{{ $pegawai2->nama_pegawai }}</p>
                        </div>
                    </div>
                @endisset
                <div class="mt-4">
                    <label class="fw-bold">Tanda Tangan Wajib Pajak</label>
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <canvas id="signature-pad" width="500" height="200"
                            style="border:1px solid #ccc; max-width:100%;"></canvas>
                    </div>


                    <input type="hidden" name="ttd_wajib_pajak" id="ttd_wajib_pajak">

                    <div class="mt-2">
                        <button type="button" class="btn btn-secondary btn-sm" id="clear-signature">
                            Clear Tanda Tangan
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <input type="hidden" name="nop" value="{{ $nop }}">
                    <input type="hidden" name="nama" value="{{ $nama }}">
                    <input type="hidden" name="alamat" value="{{ $alamat }}">
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

            // Mobile support
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

            // Styling garis
            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
        });
    </script>

@endsection
