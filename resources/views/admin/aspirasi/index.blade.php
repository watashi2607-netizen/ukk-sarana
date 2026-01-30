@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Aspirasi</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filter Aspirasi</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.aspirasi.index') }}">
            <div class="row">
                <div class="col-md-6">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="">Semua Status</option>
                        <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="id_kategori">Kategori</label>
                    <select class="form-control" id="id_kategori" name="id_kategori">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id_kategori }}" {{ request('id_kategori') == $kategori->id_kategori ? 'selected' : '' }}>{{ $kategori->ket_kategori }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Filter</button>
            <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-secondary mt-3">Reset</a>
        </form>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pelapor</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($aspirasis as $aspirasi)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $aspirasi->inputAspirasi->siswa->nama ?? 'N/A' }}</td>
                        <td>{{ $aspirasi->kategori->ket_kategori }}</td>
                        <td>{{ $aspirasi->inputAspirasi->lokasi }}</td>
                       
                        <td>
                            <span class="badge badge-{{ $aspirasi->status == 'menunggu' ? 'warning' : ($aspirasi->status == 'proses' ? 'info' : 'success') }}">
                                {{ ucfirst($aspirasi->status) }}
                            </span>
                        </td>
                        <td>{{ $aspirasi->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('admin.aspirasi.show', $aspirasi->id_aspirasi) }}" class="btn btn-sm btn-info">Lihat</a>
                            @if($aspirasi->status != 'selesai')
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#updateStatusModal{{ $loop->iteration }}">
                                Status
                            </button>
                            @endif
                        </td>
                    </tr>

                    <!-- Modal Update Status -->
                    <div class="modal fade" id="updateStatusModal{{ $loop->iteration }}" tabindex="-1" role="dialog" aria-labelledby="updateStatusModalLabel{{ $loop->iteration }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateStatusModalLabel{{ $loop->iteration }}">Update Status Aspirasi</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('admin.aspirasi.update-status', $aspirasi) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="status{{ $loop->iteration }}">Status</label>
                                            <select class="form-control" id="status{{ $loop->iteration }}" name="status" required>
                                                <option value="menunggu" {{ $aspirasi->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                                <option value="proses" {{ $aspirasi->status == 'proses' ? 'selected' : '' }}>Proses</option>
                                                <option value="selesai" {{ $aspirasi->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="feedback{{ $loop->iteration }}">Feedback (Opsional)</label>
                                            <textarea class="form-control" id="feedback{{ $loop->iteration }}" name="feedback" rows="3">{{ $aspirasi->feedback }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Update Status</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection