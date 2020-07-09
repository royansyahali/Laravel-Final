@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-light">
                <div class="card-header bg-info">Buat Pertanyaan</div>

                <div class="card-body">
                    {{-- Form --}}
                    <form action="{{route('pertanyaans.update',["pertanyaan" => $pertanyaan->id])}}" method="POST">
                        @csrf
                        @method("PUT")
                        <div class="form-group">
                          <label for="judul">Judul</label>
                          <input type="text" class="form-control @error("judul") is-invalid @enderror" id="judul"  name="judul" value="{{old("judul")??$pertanyaan->judul}}">
                        @error("judul")
                          <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                        </div>
                        <div class="form-group">
                          <label for="pertanyaan">Pertanyaan</label>
                          <input type="text" class="form-control @error("pertanyaan") is-invalid @enderror" id="pertanyaan" name="pertanyaan" value="{{old("pertanyaan")??$pertanyaan->pertanyaan}}">
                        @error("pertanyaan")
                          <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                        </div>
                        <div class="form-group">
                            <label for="tag">Tag</label>
                            <input type="text" class="form-control @error("tag") is-invalid @enderror" id="tag" name="tag" value="{{old("tag")??$tag}}">
                        <small>Di Pisahkan Dengan Koma (,)</small>
                        @error("tag")
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{route('pertanyaans.index')}}" type="button" class="btn btn-dark">Kembali</a>
                    </form>
                    </form>
                {{-- /Form --}}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
