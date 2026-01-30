@extends('layouts.siswa')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Aspirasi</h1>
    <a href="{{ route('siswa.riwayat') }}" class="btn btn-secondary">Kembali</a>
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
                        <p><strong>Kategori:</strong> {{ $inputAspirasi->kategori->ket_kategori }}</p>
                        <p><strong>Lokasi:</strong> {{ $inputAspirasi->lokasi }}</p>
                        
                    </div>
                    <div class="col-md-6">
                        <p><strong>Dibuat:</strong> {{ $inputAspirasi->created_at->format('d/m/Y') }}</p>
                        <p><strong>Status:</strong> <span id="currentStatus">
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
                        </span></p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <p><strong>Keterangan:</strong></p>
                        <p>{{ $inputAspirasi->keterangan }}</p>
                    </div>
                </div>

                @if($inputAspirasi->gambar)
                <div class="row mt-3">
                    <div class="col-md-12">
                        <p><strong>Gambar:</strong></p>
                        <img src="{{ asset('storage/' . $inputAspirasi->gambar) }}" alt="Gambar Aspirasi" class="img-fluid" style="max-width: 100%; height: auto;">
                    </div>
                </div>
                @endif
            </div>
        </div>

                <div id="feedbackContainer">
                    @if($inputAspirasi->aspirasi && $inputAspirasi->aspirasi->feedback)
                    <div class="card shadow mb-4" id="feedbackCard">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Feedback Admin</h6>
                        </div>
                        <div class="card-body" id="feedbackBody">
                            <p>{{ $inputAspirasi->aspirasi->feedback }}</p>
                        </div>
                    </div>
                    @endif
                </div>
    </div>
</div>
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

    async function checkDetailUpdate() {
        const id = '{{ $inputAspirasi->id_pelaporan }}';
        try {
            const res = await fetch(`/siswa/aspirasi/${id}/status`, { credentials: 'same-origin' });
            if (!res.ok) return;
            const data = await res.json();

            const statusEl = document.querySelector('#currentStatus');
            if (statusEl) {
                const newHtml = getBadgeHtml(data.status);
                if (statusEl.innerHTML.trim() !== newHtml.trim()) {
                    statusEl.innerHTML = newHtml;
                }
            }

            const feedbackContainer = document.querySelector('#feedbackContainer');
            if (data.feedback) {
                if (!document.querySelector('#feedbackCard')) {
                    const card = document.createElement('div');
                    card.id = 'feedbackCard';
                    card.className = 'card shadow mb-4';
                    card.innerHTML = '<div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Feedback Admin</h6></div><div class="card-body" id="feedbackBody"><p></p></div>';
                    feedbackContainer.appendChild(card);
                }
                document.querySelector('#feedbackBody p').textContent = data.feedback;
            } else {
                const card = document.querySelector('#feedbackCard');
                if (card) card.remove();
            }
        } catch (e) {
            console.error('Error fetching detail update', e);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // mark status element for easy update
        const statusBlock = document.querySelector('p strong + span');
        if (statusBlock) {
            statusBlock.id = 'currentStatus';
        }

        checkDetailUpdate();
        setInterval(checkDetailUpdate, 10000);
    });
})();
</script>
@endpush

@endsection