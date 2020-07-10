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
            <form  action="{{route('jawabans.store',["id" => $pertanyaan->id])}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="jawaban" class="font-weight-bold">Jawaban Anda</label>
                    <textarea class="form-control" id="jawaban" rows="3" name="jawaban">{{old("jawaban")}}</textarea>
                @error("jawaban")
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                <a href="{{route('komentars.pertanyaan.index',['id' => $pertanyaan->id])}}" type="button" class="btn btn-info btn-sm ">Komentar</a>
                <a href="{{route('pertanyaans.index')}}" type="button" class="btn btn-dark btn-sm ">Kembali</a>
            </form>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8 bg-light">
            <table class="table text-center">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Jawaban</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Valid</th>
                    <th scope="col">Detail</th>
                  </tr>
                </thead>
                <tbody>
                @forelse ($pertanyaan->jawaban as $key => $item)
                    <tr>
                        <th scope="row">{{$key +1}}</th>
                        <td>{{$item->jawaban}}</td>
                        <td>{{$item->user->name}}</td>
                        @if ($item->valid)
                            <td>
                            <form class="d-inline " action="{{route("valid.jawaban",["id" => $item->id])}}" method='POST'>
                                @csrf
                                @method("DELETE")
                                <button class="btn btn-success" type="submit">Valid</button>
                            </form>
                            Valid
                            </td>
                        @else
                            <td>
                            <form class="d-inline " action="{{route("valid.jawaban",["id" => $item->id])}}" method='POST'>
                                @csrf
                                @method("DELETE")
                                <button class="btn btn-success" type="submit">Validasi</button>
                            </form>
                            Belum Valid
                            </td>
                        @endif

                        <td>
                            <a class="btn btn-info" href="{{route("jawabans.show",["id" => $item->id])}}" role="button">Lihat</a>
                            <form class="d-inline " action="{{route("upvote.jawaban",["id" => $item->id])}}" method='POST'>
                                @csrf
                                @method("DELETE")
                                <button class="btn btn-success" type="submit">Like</button>
                            </form>
                            <form class="d-inline " action="{{route("downvote.jawaban",["id" => $item->id])}}" method='POST'>
                                @csrf
                                @method("DELETE")
                                <button class="btn btn-danger" type="submit">Dislike</button>
                            </form>
                            <button class="btn btn-info" type="button">{{$item->poin}}</button>
                        </td>
                    </tr>
                @empty
                    <td colspan="5" class="alert alert-info font-weight-bold text-dark" role="alert">
                        Belum ada
                    </td>
                @endforelse
              </table>
        </div>
    </div>
</div>
@endsection
