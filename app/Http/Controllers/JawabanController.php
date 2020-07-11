<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jawaban;
use App\Komentar;
use App\Pertanyaan;
use App\User;
use App\Votejawaban;
use App\Votejawabanup;
use Illuminate\Support\Facades\Auth;
class JawabanController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $validasi = $request->validate([
            "jawaban" => 'required',
        ]);
        // Create Jawaban
        Jawaban::create([
            "jawaban" => ucfirst(strtolower($validasi["jawaban"])),
            "user_id" => Auth::id(),
            "pertanyaan_id" => $id,
        ]);
        return redirect()->route("pertanyaans.show",["pertanyaan" => $id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jawaban = Jawaban::find($id);
        return view("jawabans.show",compact('jawaban'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function valid($id)
    {
        $jawaban = Jawaban::find($id);
        $poin= $jawaban->user->poin;
        $user= $jawaban->user->id;
        if ($jawaban->pertanyaan->user->id == Auth::id()){
            if($jawaban->valid == false){
            Jawaban::where('id',$id)->update([
                'valid' => true
            ]);
            User::where("id",$user)->update([
                "poin" => $poin+=15
            ]);
                return redirect()->route("pertanyaans.show",["pertanyaan"=>$jawaban->pertanyaan->id]);
            }else{
                Jawaban::where('id',$id)->update([
                    'valid' => false
                ]);
                User::where("id",$user)->update([
                    "poin" => $poin-=15
                ]);
                return redirect()->route("pertanyaans.show",["pertanyaan"=>$jawaban->pertanyaan->id]);
            }
        }else{
            return redirect()->route("pertanyaans.show",["pertanyaan"=>$jawaban->pertanyaan->id]);
        }
    }

    public function upvote($id){
        $jawaban = Jawaban::find($id);
        $user= $jawaban->user->id;
        $pertanyaan = $jawaban->pertanyaan->id;
        $poin= $jawaban->user->poin;
        if(Auth::user()->poin > 15){
            if($jawaban->votejawaban->where("user_id",Auth::id())->isNotEmpty()){
                User::where("id",$user)->update([
                    "poin" => $poin+=10
                ]);
                Jawaban::where("id",$id)->update([
                    "poin" => $jawaban->poin+=1
                ]);
                Votejawaban::where("user_id",Auth::id())
                    ->where("jawaban_id",$id)
                    ->delete();
                return redirect()->route("pertanyaans.show",["pertanyaan"=>$pertanyaan]);
            }else{
                if($jawaban->votejawabanup->where("user_id",Auth::id())->isEmpty()){
                    User::where("id",$user)->update([
                        "poin" => $poin+=10
                    ]);
                    Jawaban::where("id",$id)->update([
                        "poin" => $jawaban->poin+=1
                    ]);
                    Votejawabanup::create([
                        "user_id" => Auth::id(),
                        "jawaban_id" => $id
                    ]);
                    return redirect()->route("pertanyaans.show",["pertanyaan"=>$pertanyaan]);
                }else{
                    return redirect()->route("pertanyaans.show",["pertanyaan"=>$pertanyaan]);
                }
            }
        }else{
            return redirect()->route("pertanyaans.show",["pertanyaan"=>$pertanyaan]);
        }
    }


    public function downvote($id){
        $jawaban = Jawaban::find($id);
        $user= $jawaban->user->id;
        $pertanyaan = $jawaban->pertanyaan->id;
        $poin= $jawaban->user->poin;
        if (Auth::user()->poin > 15){
            if($jawaban->votejawabanup->where("user_id",Auth::id())->isNotEmpty()){
                User::where("id",$user)->update([
                    "poin" => $poin-=1
                ]);
                Jawaban::where("id",$id)->update([
                    "poin" => $jawaban->poin-=1
                ]);
                Votejawabanup::where("user_id",Auth::id())
                    ->where("jawaban_id",$id)
                    ->delete();
                return redirect()->route("pertanyaans.show",["pertanyaan"=>$pertanyaan]);
            }else{
                if($jawaban->votejawaban->where("user_id",Auth::id())->isEmpty()){
                    User::where("id",$user)->update([
                        "poin" => $poin-=1
                    ]);
                    Jawaban::where("id",$id)->update([
                        "poin" => $jawaban->poin-=1
                    ]);
                    Votejawaban::create([
                            "user_id" => Auth::id(),
                            "jawaban_id" => $id
                    ]);
                    return redirect()->route("pertanyaans.show",["pertanyaan"=>$pertanyaan]);
                }else{
                    return redirect()->route("pertanyaans.show",["pertanyaan"=>$pertanyaan]);
                }
            }
        }else{
            return redirect()->route("pertanyaans.show",["pertanyaan"=>$pertanyaan]);
        }
    }
}
