@extends('layouts.app')

@push('content-head')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@endpush


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-light">
                <div class="card-header bg-info">Edit Jawaban</div>

                <div class="card-body">
                    {{-- Form --}}
                    <div class="alert alert-secondary" role="alert">
                        {!!$jawaban->pertanyaan->pertanyaan!!}
                    </div>
                    <form action="{{route('jawabans.update',["id" => $jawaban->id])}}" method="POST">
                        @csrf
                        @method("PUT")

                        <div class="form-group">
                            <label for="jawaban" class="font-weight-bold">Jawaban</label>
                            <textarea name="jawaban" id="jawaban" class="form-control my-editor @error("jawaban") is-invalid @enderror">{!!old('jawaban')??$jawaban->jawaban!!}</textarea>
                          @error("jawaban")
                            <div class="alert alert-danger">{{$message}}</div>
                          @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{route('pertanyaans.show',['pertanyaan' => $jawaban->pertanyaan->id])}}" type="button" class="btn btn-dark">Kembali</a>
                    </form>
                {{-- /Form --}}

                </div>
            </div>
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
