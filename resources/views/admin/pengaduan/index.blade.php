@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Pengaduan</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filter Pengaduan</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.pengaduan.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ request('tanggal') }}">
                </div>
                <div class="col-md-3">
                    <label for="bulan">Bulan</label>
                    <select class="form-control" id="bulan" name="bulan">
                        <option value="">Pilih Bulan</option>
                        @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="siswa_id">Siswa</label>
                    <select class="form-control" id="siswa_id" name="siswa_id">
                        <option value="">Pilih Siswa</option>
                        @foreach($siswas as $siswa)
                        <option value="{{ $siswa->id }}" {{ request('siswa_id') == $siswa->id ? 'selected' : '' }}>{{ $siswa->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="kategori_id">Kategori</label>
                    <select class="form-control" id="kategori_id" name="kategori_id">
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Filter</button>
            <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary mt-3">Reset</a>
        </form>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pelapor</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengaduans as $pengaduan)
                    <tr>
                        <td>{{ $pengaduan->id }}</td>
                        <td>{{ $pengaduan->siswa->nama }}</td>
                        <td>{{ $pengaduan->kategori->nama }}</td>
                        <td>
                            @php
                                $deskripsi = $pengaduan->deskripsi;
                                $maxLength = 50;
                                if (strlen($deskripsi) > $maxLength) {
                                    $deskripsi = substr($deskripsi, 0, $maxLength) . '...';
                                }
                            @endphp
                            {{ $deskripsi }}
                        </td>
                        <td>
                            <span class="badge badge-{{ $pengaduan->status == 'masuk' ? 'warning' : 'success' }}">
                                {{ ucfirst($pengaduan->status) }}
                            </span>
                        </td>
                        <td>
                            @if($pengaduan->status == 'masuk')
                            <form action="{{ route('admin.pengaduan.update-status', $pengaduan) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Tandai sebagai selesai?')">Selesai</button>
                            </form>
                            @else
                            <span class="text-success">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection