@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-success font-weight-bold text-dark mb-2" role="alert">
                List Pertanyaan
            </div>
            <table class="table text-center">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Pertanyaan</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                @forelse ($pertanyaans as $key => $item)
                    <tr>
                        <th scope="row">{{$key +1}}</th>
                        <td><a href="{{route("pertanyaans.show",["pertanyaan" => $item->id])}}" class="font-weight-bold text-dark">{{$item->judul}}</a></td>
                        <td>{{$item->pertanyaan}}</td>
                        <td>
                            <a class="btn btn-info" href="{{route("pertanyaans.edit",["pertanyaan" => $item->id])}}" role="button">Edit</a>
                            <form action="{{route("pertanyaans.destroy",["pertanyaan" => $item->id])}}" method="POST" class="d-inline">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <div class="alert alert-info font-weight-bold text-dark" role="alert">
                        Belum ada
                    </div>
                @endforelse
              </table>
        </div>
    </div>
</div>
@endsection
