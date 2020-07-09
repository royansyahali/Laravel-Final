@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <ul class="list-group text-dark">
                <li>Judul: {{$pertanyaan->judul}}</li>
                <li>Pertanyaan: {{$pertanyaan->pertanyaan}}</li>
                <li>Pembuat: {{$pertanyaan->user->name}}</li>
                <li>dibuat: {{$pertanyaan->created_at}}</li>
                <li>diperbaharui: {{$pertanyaan->updated_at}}</li>
            </ul>

            <div class="row">
            <div class="col-12">
                @foreach ($pertanyaan->tag as $val)
                            <button type="button" class="btn btn-success">{{$val->name}}</button>
                @endforeach
        </div>
    </div>
</div>
@endsection
