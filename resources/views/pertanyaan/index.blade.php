@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-success font-weight-bold text-dark mb-2" role="alert">
                <a href="{{route('pertanyaans.create')}}" type="button" class="btn btn-primary btn-sm">Buat Pertanyaan</a>
                List Pertanyaan
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <table class="table text-center">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Pertanyaan</th>
                    <th scope="col">Detail</th>
                    <th scope="col">Up Down</th>
                  </tr>
                </thead>
                <tbody>
                @forelse ($pertanyaans as $key => $item)
                    <tr>
                        <th scope="row">{{$key +1}}</th>
                        <td>{{$item->judul}}</td>
                        <td>{!!$item->pertanyaan!!}</td>
                        <td class="ml-2">
                            <a class="btn btn-info" href="{{route("pertanyaans.show",["pertanyaan" => $item->id])}}" role="button">Lihat</a>
                            @if ($item->user->id == Auth::id())
                            <a class="btn btn-warning" href="{{route("pertanyaans.edit",["pertanyaan" => $item->id])}}" role="button">Edit</a>
                            @endif
                        </td>
                        <td>
                            <form class="d-inline " action="{{route("upvote.pertanyaan",["id" => $item->id])}}" method='POST'>
                                @csrf
                                @method("DELETE")
                                <button class="btn btn-success" type="submit">Up</button>
                            </form>
                            <form class="d-inline " action="{{route("downvote.pertanyaan",["id" => $item->id])}}" method='POST'>
                                @csrf
                                @method("DELETE")
                                <button class="btn btn-danger" type="submit">Down</button>
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
