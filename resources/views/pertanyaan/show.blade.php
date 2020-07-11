@extends('layouts.app')

@push('content-head')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <div class="jumbotron">
                    <h3>Judul: {{$pertanyaan->judul}}</h3>
                    <hr class="my-4">
                    <h5>{!!$pertanyaan->pertanyaan!!}</h5>
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
                    <label for="jawaban" class="font-weight-bold">Jawaban</label>
                    <textarea name="jawaban" id="jawaban" class="form-control my-editor @error("jawaban") is-invalid @enderror">{!!old('jawaban')!!}</textarea>
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

            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

            <table class="table text-center">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Jawaban</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Valid</th>
                    <th scope="col">Detail</th>
                    <th scope="col">Up Down</th>
                  </tr>
                </thead>
                <tbody>
                @forelse ($pertanyaan->jawaban as $key => $item)
                    <tr>
                        <th scope="row">{{$key +1}}</th>
                        <td>{!!$item->jawaban!!}</td>
                        <td>{{$item->user->name}}</td>
                        @if ($item->valid)
                            @if ($pertanyaan->user->id == Auth::id())
                            <td>
                                <form class="d-inline " action="{{route("valid.jawaban",["id" => $item->id])}}" method='POST'>
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn btn-success" type="submit">Valid</button>
                                </form>
                            </td>
                            @else
                                <td>
                                    Valid
                                </td>
                            @endif
                        @else
                            @if ($pertanyaan->user->id == Auth::id())
                            <td>
                                <form class="d-inline " action="{{route("valid.jawaban",["id" => $item->id])}}" method='POST'>
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn btn-danger" type="submit">Belum Valid</button>
                                </form>
                                </td>
                            @else
                                <td>
                                    Belum Valid
                                </td>
                            @endif
                        @endif

                        <td>
                            <a class="btn btn-info" href="{{route("jawabans.show",["id" => $item->id])}}" role="button">Lihat</a>
                            @if ($item->user->id == Auth::id())
                                <a class="btn btn-warning" href="{{route("jawabans.edit",["id" => $item->id])}}" role="button">Edit</a>
                            @endif
                        </td>
                        <td>
                            <form class="d-inline " action="{{route("upvote.jawaban",["id" => $item->id])}}" method='POST'>
                                @csrf
                                @method("DELETE")
                                <button class="btn btn-success" type="submit">Up</button>
                            </form>
                            <form class="d-inline " action="{{route("downvote.jawaban",["id" => $item->id])}}" method='POST'>
                                @csrf
                                @method("DELETE")
                                <button class="btn btn-danger" type="submit">Down</button>
                            </form>
                            <button class="btn btn-info" type="button">{{$item->poin}}</button>
                        </td>
                    </tr>
                @empty
                    <td colspan="6" class="alert alert-info font-weight-bold text-dark" role="alert">
                        Belum ada
                    </td>
                @endforelse
              </table>
        </div>
    </div>
</div>
@endsection
@push('content-tail')
<script>
    var editor_config = {
      path_absolute : "/",
      selector: "textarea.my-editor",
      plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
      relative_urls: false,
      file_browser_callback : function(field_name, url, type, win) {
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
        var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

        var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
        if (type == 'image') {
          cmsURL = cmsURL + "&type=Images";
        } else {
          cmsURL = cmsURL + "&type=Files";
        }

        tinyMCE.activeEditor.windowManager.open({
          file : cmsURL,
          title : 'Filemanager',
          width : x * 0.8,
          height : y * 0.8,
          resizable : "yes",
          close_previous : "no"
        });
      }
    };

    tinymce.init(editor_config);
  </script>
@endpush


