@extends('admin.index')


@section('content')
    <h1>Buat Berita Acara</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('berita_acara.approval_wajib_pajak')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-2">
                        <strong><p>NOP</p></strong>
                    </div>
                    <div class="col-lg-10">
                        <p>{{ $nop }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2 font-weight-bold">
                        <strong><p>Nama</p></strong>
                    </div>
                    <div class="col-lg-10">
                        <p>{{ $nama }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2 font-weight-bold">
                        <strong><p>Alamat</p></strong>
                    </div>
                    <div class="col-lg-10">
                        <p>{{ $alamat }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-2 font-weight-bold">
                        <strong><p>Nama Responden</p></strong>
                    </div>
                    <div class="col-lg-10">
                        <input type="text" name="nama_responden" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-2 font-weight-bold">
                        <strong><p>Nomer Whatsapp</p></strong>
                    </div>
                    <div class="col-lg-10">
                        <input type="number" name="telp" class="form-control" required>
                    </div>
                </div>
                <textarea id="summernote" name="narasi"></textarea>
                <div class="row mt-3">
                    <div class="col-lg-2 font-weight-bold">
                        <p>Petugas 1</p>
                    </div>
                    <div class="col-lg-10">
                        <select name="pegawai1" class="form-select" id="" required>
                            <option value="" selected disabled>Pilih Petugas 1</option>
                            @foreach ($pegawai as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_pegawai }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-2 font-weight-bold">
                        <p>Petugas 2</p>
                    </div>
                    <div class="col-lg-10">
                        <select name="pegawai2" class="form-select" id="" r>
                            <option value="" selected disabled>Pilih Petugas 2</option>
                            @foreach ($pegawai as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_pegawai }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <input type="hidden" name="nop" value="{{$nop}}">
                    <input type="hidden" name="nama" value="{{$nama}}">
                    <input type="hidden" name="alamat" value="{{$alamat}}">
                    <button type="submit" class="btn btn-primary">Masuakn Tanda Tangan Wajib Pajak</button>
                </div>
            </form>
        </div>
    </div>
@endsection
