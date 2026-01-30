<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use App\Models\InputAspirasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $totalAspirasiMenunggu = Aspirasi::where('status', 'menunggu')->count();
            $totalAspirasiProses = Aspirasi::where('status', 'proses')->count();
            $totalAspirasiSelesai = Aspirasi::where('status', 'selesai')->count();
            $totalInputAspirasi = InputAspirasi::count();

            return view('admin.dashboard', compact(
                'totalAspirasiMenunggu',
                'totalAspirasiProses',
                'totalAspirasiSelesai',
                'totalInputAspirasi'
            ));
        } catch (\Exception $e) {
            \Log::error('Admin dashboard error', ['error' => $e->getMessage()]);
            return view('admin.dashboard', [
                'totalAspirasiMenunggu' => 0,
                'totalAspirasiProses' => 0,
                'totalAspirasiSelesai' => 0,
                'totalInputAspirasi' => 0
            ]);
        }
    }
}
