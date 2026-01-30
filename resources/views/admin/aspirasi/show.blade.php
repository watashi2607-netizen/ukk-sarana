@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Aspirasi #{{ $aspirasi->id_aspirasi }}</h1>
    <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Aspirasi</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Siswa:</strong> {{ $aspirasi->inputAspirasi->siswa->nama ?? 'N/A' }}</p>
                        <p><strong>Kategori:</strong> {{ $aspirasi->kategori->ket_kategori }}</p>
                        <p><strong>Lokasi:</strong> {{ $aspirasi->inputAspirasi->lokasi }}</p>
                        
                    </div>
                    <div class="col-md-6">
                        <p><strong>Keterangan:</strong> {{ $aspirasi->inputAspirasi->keterangan }}</p>
                        <p><strong>Dibuat:</strong> {{ $aspirasi->created_at->format('d/m/Y') }}</p>
                        <p><strong>Status:</strong>
                            <span class="badge badge-{{ $aspirasi->status == 'menunggu' ? 'warning' : ($aspirasi->status == 'proses' ? 'info' : 'success') }}">
                                {{ ucfirst($aspirasi->status) }}
                            </span>
                        </p>
                    </div>
                </div>

                @if($aspirasi->inputAspirasi->gambar)
                <div class="row mt-3">
                    <div class="col-md-12">
                        <p><strong>Gambar:</strong></p>
                        <img src="{{ asset('storage/' . $aspirasi->inputAspirasi->gambar) }}" alt="Gambar Aspirasi" class="img-fluid" style="max-width: 100%; height: auto;">
                    </div>
                </div>
                @endif
            </div>
        </div>

        @if($aspirasi->feedback)
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Feedback Admin</h6>
            </div>
            <div class="card-body">
                <p>{{ $aspirasi->feedback }}</p>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Update Status</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.aspirasi.update-status', $aspirasi) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="menunggu" {{ $aspirasi->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="proses" {{ $aspirasi->status == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ $aspirasi->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="feedback">Feedback (Opsional)</label>
                        <textarea class="form-control" id="feedback" name="feedback" rows="4">{{ $aspirasi->feedback }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Update Status</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection