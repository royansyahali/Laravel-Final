<?php

namespace App\Http\Controllers;
use App\Jawaban;
use App\Komentar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class KomentarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function jawabanstore(Request $request, $id)
    {
        $validasi = $request->validate([
            "komentar" => 'required',
        ]);
        // Create Jawaban
        $komentar = Komentar::create([
            "komentar" => ucfirst(strtolower($validasi["komentar"])),
            "user_id" => Auth::id(),
        ]);
        $komentar->jawaban()->attach($id,[
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
        ]);
        return redirect()->route("jawabans.show",["id" => $id]);

    }
    public function pertanyaanstore(Request $request, $id)
    {
        $validasi = $request->validate([
            "komentar" => 'required',
        ]);
        // Create Jawaban
        $komentar = Komentar::create([
            "komentar" => ucfirst(strtolower($validasi["komentar"])),
            "user_id" => Auth::id(),
        ]);
        $komentar->pertanyaan()->attach($id,[
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
        ]);
        return redirect()->route("komentars.pertanyaan.index",["id" => $id]);

    }
}
