<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Agunan;
use App\Models\User;
use App\Models\Scan;
use Illuminate\Support\Facades\DB;


class ReportController extends Controller
{
    public function index()
    {
        // Menghitung total dokumen
        $totalDocuments = Document::count();

        // Menghitung total agunan
        $totalAgunan = Agunan::count();

        // Menghitung total nilai dokumen
        $totalNilaiDocument = Document::sum('pinjaman');

        // Menghitung total CIF unik (tanpa duplikasi)
        $totalCIF = Document::distinct('cif')->count('cif');

        // Menghitung total user (kecuali admin)
        $totalUser = User::all()->except(1)->count();

        // Ambil log scan dengan total scan dan waktu terakhir scan
        $logScans = Scan::select('updated_at', DB::raw('COUNT(*) as total'))
            ->groupBy('updated_at')
            ->orderBy('updated_at', 'desc')
            ->get();

        // Menghitung total dokumen yang ditemukan 
        $totalKetemu = Document::where('is_there', 1)->count();

        // Menghitung total dokumen yang hilang 
        $totalHilang = Document::where('is_there', 0)->count();


        return view('report.index', compact(
            'totalDocuments',
            'totalAgunan',
            'totalCIF',
            'totalNilaiDocument',
            'totalUser',
            'logScans',
            'totalHilang',
            'totalKetemu'
        ));
    }
}
