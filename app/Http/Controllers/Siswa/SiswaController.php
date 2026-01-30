<?php

namespace App\Http\Controllers\Siswa;

use Illuminate\Http\Request;
use App\Models\InputAspirasi;
use App\Models\Aspirasi;
use App\Models\Kategori;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SiswaController extends \App\Http\Controllers\Controller
{
    public function dashboard()
    {
        try {
            $siswa = session('user');
            $userType = session('user_type');
            
            Log::info('Dashboard access attempt', [
                'user_type' => $userType,
                'siswa_exists' => $siswa ? 'yes' : 'no',
                'siswa_name' => $siswa ? $siswa->nama : 'null'
            ]);
            
            if (!$siswa || $userType !== 'siswa') {
                Log::warning('Unauthorized access to siswa dashboard', [
                    'user_type' => $userType,
                    'siswa' => $siswa
                ]);
                return redirect('/login')->withErrors(['login' => 'Silakan login sebagai siswa terlebih dahulu.']);
            }
            
            $totalInputAspirasi = InputAspirasi::where('nis', $siswa->nis)->count();
            $totalAspirasiSelesai = Aspirasi::whereHas('inputAspirasi', function($query) use ($siswa) {
                $query->where('nis', $siswa->nis);
            })->where('status', 'selesai')->count();
            $totalAspirasiMenunggu = Aspirasi::whereHas('inputAspirasi', function($query) use ($siswa) {
                $query->where('nis', $siswa->nis);
            })->where('status', 'menunggu')->count();
            
            return view('siswa.dashboard', compact('siswa', 'totalInputAspirasi', 'totalAspirasiSelesai', 'totalAspirasiMenunggu'));
        } catch (\Exception $e) {
            Log::error('Siswa dashboard error', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect('/login')->withErrors(['login' => 'Terjadi kesalahan sistem.']);
        }
    }

    public function inputAspirasi()
    {
        $siswa = Session::get('user');
        $kategoris = Kategori::all();
        return view('siswa.input-aspirasi', compact('siswa', 'kategoris'));
    }

    public function storeAspirasi(Request $request)
    {
        $siswa = Session::get('user');
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id_kategori',
            'lokasi' => 'required|string|max:255',
            'keterangan' => 'required|string|max:1000',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('aspirasi', 'public');
        }

        $inputAspirasi = InputAspirasi::create([
            'nis' => $siswa->nis,
            'id_kategori' => $request->kategori_id,
            'lokasi' => $request->lokasi,
            'keterangan' => $request->keterangan,
            'gambar' => $gambarPath,
        ]);

        // Buat aspirasi terkait
        Aspirasi::create([
            'status' => 'menunggu',
            'id_kategori' => $request->kategori_id,
            'id_pelaporan' => $inputAspirasi->id_pelaporan,
        ]);

        return redirect()->route('siswa.riwayat')->with('success', 'Aspirasi berhasil dikirim');
    }

    public function riwayat()
    {
        $siswa = Session::get('user');
        $inputAspirasis = InputAspirasi::where('nis', $siswa->nis)->with(['kategori', 'aspirasi'])->get();
        return view('siswa.riwayat', compact('siswa', 'inputAspirasis'));
    }

    public function detailAspirasi($id)
    {
        $siswa = Session::get('user');
        $inputAspirasi = InputAspirasi::where('nis', $siswa->nis)->where('id_pelaporan', $id)->with(['kategori', 'aspirasi'])->firstOrFail();
        return view('siswa.detail-aspirasi', compact('siswa', 'inputAspirasi'));
    }

    public function editAspirasi($id)
    {
        $siswa = Session::get('user');
        $inputAspirasi = InputAspirasi::where('nis', $siswa->nis)->where('id_pelaporan', $id)->firstOrFail();
        $kategoris = Kategori::all();
        return view('siswa.edit-aspirasi', compact('siswa', 'inputAspirasi', 'kategoris'));
    }

    public function updateAspirasi(Request $request, $id)
    {
        $siswa = Session::get('user');
        $inputAspirasi = InputAspirasi::where('nis', $siswa->nis)->where('id_pelaporan', $id)->firstOrFail();

        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id_kategori',
            'lokasi' => 'required|string|max:255',
            'keterangan' => 'required|string|max:1000',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambarPath = $inputAspirasi->gambar;
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($inputAspirasi->gambar) {
                Storage::disk('public')->delete($inputAspirasi->gambar);
            }
            $gambarPath = $request->file('gambar')->store('aspirasi', 'public');
        }

        $inputAspirasi->update([
            'id_kategori' => $request->kategori_id,
            'lokasi' => $request->lokasi,
            'keterangan' => $request->keterangan,
            'gambar' => $gambarPath,
        ]);

        // Update kategori di aspirasi juga
        $inputAspirasi->aspirasi->update([
            'id_kategori' => $request->kategori_id,
        ]);

        return redirect()->route('siswa.riwayat')->with('success', 'Aspirasi berhasil diupdate');
    }

    public function deleteAspirasi($id)
    {
        $siswa = Session::get('user');
        $inputAspirasi = InputAspirasi::where('nis', $siswa->nis)->where('id_pelaporan', $id)->firstOrFail();

        // Hapus gambar jika ada
        if ($inputAspirasi->gambar) {
            Storage::disk('public')->delete($inputAspirasi->gambar);
        }

        // Hapus aspirasi terkait
        if ($inputAspirasi->aspirasi) {
            $inputAspirasi->aspirasi->delete();
        }

        $inputAspirasi->delete();

        return redirect()->route('siswa.riwayat')->with('success', 'Aspirasi berhasil dihapus');
    }

    public function aspirasiStatus($id)
    {
        $siswa = Session::get('user');
        $inputAspirasi = InputAspirasi::where('nis', $siswa->nis)->where('id_pelaporan', $id)->with('aspirasi')->firstOrFail();

        return response()->json([
            'status' => $inputAspirasi->aspirasi->status ?? null,
            'feedback' => $inputAspirasi->aspirasi->feedback ?? null,
        ]);
    }
}