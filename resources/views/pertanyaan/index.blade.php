@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-success font-weight-bold text-dark mb-2" role="alert">
                <a href="{{route('pertanyaans.create')}}" type="button" class="btn btn-primary btn-sm">Buat Pertanyaan</a>
                List Pertanyaan
            </div>
            <table class="table text-center">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Pertanyaan</th>
                    <th scope="col">Detail</th>
                  </tr>
                </thead>
                <tbody>
                @forelse ($pertanyaans as $key => $item)
                    <tr>
                        <th scope="row">{{$key +1}}</th>
                        <td>{{$item->judul}}</td>
                        <td>{{$item->pertanyaan}}</td>
                        <td>
                            <a class="btn btn-info" href="{{route("pertanyaans.show",["pertanyaan" => $item->id])}}" role="button">Lihat</a>
                        </td>
                    </tr>
                @empty
                    <td colspan="4" class="alert alert-info font-weight-bold text-dark" role="alert">
                        Belum ada
                    </td>
                @endforelse
              </table>
        </div>
    </div>
</div>
@endsection
