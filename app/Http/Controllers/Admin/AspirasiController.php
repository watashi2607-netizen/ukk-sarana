<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AspirasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Aspirasi::with('kategori', 'inputAspirasi.siswa');

        // Filter per status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter per kategori
        if ($request->filled('id_kategori')) {
            $query->where('id_kategori', $request->id_kategori);
        }

        $aspirasis = $query->get();
        $kategoris = Kategori::all();

        return view('admin.aspirasi.index', compact('aspirasis', 'kategoris'));
    }

    public function updateStatus(Request $request, Aspirasi $aspirasi)
    {
        $request->validate([
            'status' => 'required|in:menunggu,proses,selesai',
            'feedback' => 'nullable|string|max:1000',
        ]);

        $aspirasi->update([
            'status' => $request->status,
            'feedback' => $request->feedback,
        ]);

        return redirect()->route('admin.aspirasi.index')->with('success', 'Status aspirasi berhasil diupdate.');
    }

    public function show($id)
    {
        $aspirasi = Aspirasi::with('kategori', 'inputAspirasi.siswa')->findOrFail($id);
        return view('admin.aspirasi.show', compact('aspirasi'));
    }
}
