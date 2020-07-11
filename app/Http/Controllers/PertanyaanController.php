<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pertanyaan;
use App\Tag;
use App\Jawaban;
use App\Votepertanyaan;
use App\Votepertanyaanup;
use App\User;
use Illuminate\Support\Facades\Auth;

use function Symfony\Component\VarDumper\Dumper\esc;

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

    public function upvote($id){
        $pertanyaan = Pertanyaan::find($id);
        $user= $pertanyaan->user->id;
        $poin= $pertanyaan->user->poin;
        if (Auth::user()->poin > 15){
            if($pertanyaan->votepertanyaan->where("user_id",Auth::id())->isNotEmpty()){
                User::where("id",$user)->update([
                    "poin" => $poin+=10
                ]);
                Pertanyaan::where("id",$id)->update([
                    "poin" => $pertanyaan->poin+=1
                ]);
                Votepertanyaan::where("user_id",Auth::id())
                    ->where("pertanyaan_id",$id)
                    ->delete();
                return redirect()->route("pertanyaans.index");
            }else{
                if($pertanyaan->votepertanyaanup->where("user_id",Auth::id())->isEmpty()){
                    User::where("id",$user)->update([
                        "poin" => $poin+=10
                    ]);
                    Pertanyaan::where("id",$id)->update([
                        "poin" => $pertanyaan->poin+=1
                    ]);
                    Votepertanyaanup::where("user_id",Auth::id())
                        ->where("pertanyaan_id",$id)
                        ->delete();
                    Votepertanyaanup::create([
                            "user_id" => Auth::id(),
                            "pertanyaan_id" => $id
                    ]);
                    return redirect()->route("pertanyaans.index");
                }else{
                    return redirect()->route("pertanyaans.index");
                }
            }
        }else{
            return redirect()->route("pertanyaans.index");
        }
    }


    public function downvote($id){
        $pertanyaan = Pertanyaan::find($id);
        $user= $pertanyaan->user->id;
        $poin= $pertanyaan->user->poin;
        if(Auth::user()->poin > 15){
            if($pertanyaan->votepertanyaanup->where("user_id",Auth::id())->isNotEmpty()){
                User::where("id",$user)->update([
                    "poin" => $poin-=1
                ]);
                Pertanyaan::where("id",$id)->update([
                    "poin" => $pertanyaan->poin-=1
                ]);
                Votepertanyaanup::where("user_id",Auth::id())
                    ->where("pertanyaan_id",$id)
                    ->delete();
                return redirect()->route("pertanyaans.index");
            }else{
                if($pertanyaan->votepertanyaan->where("user_id",Auth::id())->isEmpty()){
                    User::where("id",$user)->update([
                        "poin" => $poin-=1
                    ]);
                    Pertanyaan::where("id",$id)->update([
                        "poin" => $pertanyaan->poin-=1
                    ]);
                    Votepertanyaan::create([
                            "user_id" => Auth::id(),
                            "pertanyaan_id" => $id
                    ]);
                    return redirect()->route("pertanyaans.index");
                }else{
                    return redirect()->route("pertanyaans.index");
                }
            }
        }else{
            return redirect()->route("pertanyaans.index");
        }
    }

}
