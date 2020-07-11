@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <div class="jumbotron">
                    <h3>Judul: {{$pertanyaan->judul}}</h3>
                    <hr class="my-4">
                    <h5>Pertanyaan: {{$pertanyaan->pertanyaan}}</h5>
                    <h5>Created: {{$pertanyaan->created_at->format('Y-m-d')}}</h5>
                    <h5>Updated: {{$pertanyaan->updated_at->format('Y-m-d')}}</h5>
                    @foreach ($pertanyaan->tag as $val)
                                    <button type="button" class="btn btn-success">{{$val->name}}</button>
                    @endforeach
                </div>
        </div>
    </div>
    <div class="row justify-content-center mb-2">
        <div class="col-md-8 bg-light">
            <form  action="{{route('komentars.pertanyaan',["id" => $pertanyaan->id])}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="komentar" class="font-weight-bold">Komentar Anda</label>
                    <textarea class="form-control" id="komentar" rows="3" name="komentar">{{old("komentar")}}</textarea>
                @error("komentar")
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                <a href="{{route('pertanyaans.show',['pertanyaan' => $pertanyaan->id])}}" type="button" class="btn btn-dark btn-sm ">Kembali</a>
            </form>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8 bg-light">
            <table class="table text-center">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Komentar</th>
                  </tr>
                </thead>
                <tbody>
                @forelse ($pertanyaan->komentar as $key => $item)
                    <tr>
                        <th scope="row">{{$key +1}}</th>
                        <td>{{$item->komentar}}</td>
                        <td>{{$item->user->name}}</td>

                    </tr>
                @empty
                    <td colspan="4" class="alert alert-info font-weight-bold text-dark" role="alert">
                        Belum ada
                    </td>
                @endforelse
              </table>
        </div>
</div>
@endsection

