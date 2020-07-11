<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pertanyaan;
use App\Tag;
use App\Jawaban;
use Illuminate\Support\Facades\Auth;

class PertanyaanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pertanyaans = Pertanyaan::all();
        return view("pertanyaan.index",compact('pertanyaans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("pertanyaan.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Validasi
        $validasi = $request->validate([
            "judul" => 'required|max:255',
            "pertanyaan" => 'required',
            "tag" => 'required',
        ]);
        // Create Pertanyaan
        $pertanyaan = Pertanyaan::create([
            "judul" => ucfirst(strtolower($validasi["judul"])),
            "pertanyaan" =>  ucfirst(strtolower($validasi["pertanyaan"])),
            "user_id" => Auth::id(),
        ]);
        // Create tag
        $validasi["tag"] = explode(",",$validasi["tag"]);
        foreach ($validasi["tag"] as $tag){
            $tags = Tag::firstOrCreate([
                "name" => ucfirst(strtolower($tag))
            ]);
            $pertanyaan->tag()->attach($tags->id,[
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ]);

        }
        return redirect()->route("pertanyaans.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pertanyaan = Pertanyaan::find($id);
        return view("pertanyaan.show",compact("pertanyaan"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $pertanyaan = Pertanyaan::find($id);
        // $tag = $pertanyaan->tag->implode("name",",");

        // return view("pertanyaan.edit",compact("pertanyaan","tag"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $validasi = $request->validate([
        //     "judul" => 'required|max:255',
        //     "pertanyaan" => 'required',
        //     "tag" => 'required',
        // ]);
        // // Create Pertanyaan
        //  $pertanyaan = Pertanyaan::where("id",$id)->update([
        //     "judul" => $validasi["judul"],
        //     "pertanyaan" => $validasi["pertanyaan"],
        // ]);
        // // Create tag
        // $validasi["tag"] = explode(",",$validasi["tag"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function komentar($id)
    {
        $pertanyaan = Pertanyaan::find($id);
        return view('pertanyaan.komentar',compact('pertanyaan'));
    }
}
