@extends('layouts.siswa')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Riwayat Aspirasi</h1>
</div>

<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Aspirasi Anda</h6>
            </div>
            <div class="card-body">
                @if($inputAspirasis->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Kategori</th>
                                    <th>Lokasi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inputAspirasis as $inputAspirasi)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($inputAspirasi->created_at)->format('d/m/Y') }}</td>
                                        <td>{{ $inputAspirasi->kategori->ket_kategori }}</td>
                                        <td>{{ $inputAspirasi->lokasi }}</td>
                                        <td>
                                            <span class="aspirasi-status" data-id="{{ $inputAspirasi->id_pelaporan }}">
                                                @if($inputAspirasi->aspirasi && $inputAspirasi->aspirasi->status)
                                                    @if($inputAspirasi->aspirasi->status == 'menunggu')
                                                        <span class="badge badge-warning">Menunggu</span>
                                                    @elseif($inputAspirasi->aspirasi->status == 'proses')
                                                        <span class="badge badge-info">Proses</span>
                                                    @elseif($inputAspirasi->aspirasi->status == 'selesai')
                                                        <span class="badge badge-success">Selesai</span>
                                                    @endif
                                                @else
                                                    <span class="badge badge-secondary">Belum Diproses</span>
                                                @endif
                                            </span>
                                            <small class="feedback-indicator text-info ml-2" data-id="{{ $inputAspirasi->id_pelaporan }}">
                                                @if($inputAspirasi->aspirasi && $inputAspirasi->aspirasi->feedback)
                                                    • Feedback
                                                @endif
                                            </small>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Aksi Aspirasi">
                                                <a href="{{ route('siswa.detail-aspirasi', $inputAspirasi->id_pelaporan) }}" class="btn btn-sm btn-info mr-2" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </a>
                                                <a href="{{ route('siswa.edit-aspirasi', $inputAspirasi->id_pelaporan) }}" class="btn btn-sm btn-warning mr-2" title="Edit">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('siswa.delete-aspirasi', $inputAspirasi->id_pelaporan) }}" method="POST" class="mr-2" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus aspirasi ini?')">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                        <p class="text-gray-500">Belum ada aspirasi yang diajukan.</p>
                        <a href="{{ route('siswa.input-aspirasi') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Buat Aspirasi Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if($inputAspirasis->count() > 0)
<div class="row">
    <div class="col-xl-12">
        <div class="card shadow mb-4">
            <div class="card-body text-center">
                <a href="{{ route('siswa.input-aspirasi') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus"></i> Buat Aspirasi Baru
                </a>
            </div>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
(function () {
    function getBadgeHtml(status) {
        if (!status) return '<span class="badge badge-secondary">Belum Diproses</span>';
        if (status === 'menunggu') return '<span class="badge badge-warning">Menunggu</span>';
        if (status === 'proses') return '<span class="badge badge-info">Proses</span>';
        if (status === 'selesai') return '<span class="badge badge-success">Selesai</span>';
        return '<span class="badge badge-secondary">'+ (status || '') +'</span>';
    }

    async function checkUpdates() {
        const statusEls = document.querySelectorAll('.aspirasi-status');
        for (const el of statusEls) {
            const id = el.dataset.id;
            try {
                const res = await fetch(`/siswa/aspirasi/${id}/status`, { credentials: 'same-origin' });
                if (!res.ok) continue;
                const data = await res.json();
                const newHtml = getBadgeHtml(data.status);
                if (el.innerHTML.trim() !== newHtml.trim()) {
                    el.innerHTML = newHtml;
                }
                const feedEl = document.querySelector('.feedback-indicator[data-id="' + id + '"]');
                if (feedEl) {
                    if (data.feedback) {
                        feedEl.textContent = '• Feedback';
                        feedEl.title = data.feedback;
                    } else {
                        feedEl.textContent = '';
                        feedEl.title = '';
                    }
                }
            } catch (e) {
                console.error('Error checking aspirasi status', e);
            }
        }
    }

    // Initial check and periodic polling
    document.addEventListener('DOMContentLoaded', function() {
        checkUpdates();
        setInterval(checkUpdates, 10000);
    });
})();
</script>
@endpush

@endsection