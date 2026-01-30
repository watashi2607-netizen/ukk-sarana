@extends('layouts.siswa')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Aspirasi</h1>
    <a href="{{ route('siswa.riwayat') }}" class="btn btn-secondary">Kembali</a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Edit Aspirasi</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('siswa.update-aspirasi', $inputAspirasi->id_pelaporan) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="kategori_id">Kategori Aspirasi</label>
                        <select name="kategori_id" id="kategori_id" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id_kategori }}" {{ $inputAspirasi->id_kategori == $kategori->id_kategori ? 'selected' : '' }}>{{ $kategori->ket_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" name="lokasi" id="lokasi" class="form-control" value="{{ $inputAspirasi->lokasi }}" placeholder="Masukkan lokasi kejadian..." required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan Aspirasi</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="8" placeholder="Jelaskan aspirasi atau pengaduan Anda secara detail..." required>{{ $inputAspirasi->keterangan }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="gambar">Upload Gambar (Opsional)</label>
                        @if($inputAspirasi->gambar)
                            <div class="mb-3">
                                <p><strong>Gambar saat ini:</strong></p>
                                <img src="{{ asset('storage/' . $inputAspirasi->gambar) }}" alt="Gambar Aspirasi" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        @endif
                        <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                        <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar (max 2MB, format: jpg, png, jpeg)</small>
                    </div>
                    <button type="submit" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-save"></i>
                        </span>
                        <span class="text">Simpan Perubahan</span>
                    </button>
                    <a href="{{ route('siswa.riwayat') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
