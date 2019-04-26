@extends('laravel-jumbotron-images::jumbotronImages.layout')

@section('content')
    
    @if($jumbotronImage)
        {{$jumbotronImage->title}}
        {{$jumbotronImage->body}}
        {{$jumbotronImage->button_text}}
        {{$jumbotronImage->image_file_name}}
        {{$jumbotronImage->button_url}}
    @else
        <div class="alert alert-warning" role="alert">
            No jumbotron corresponding to the specified ID has been found.
        </div>
    @endif
@endsection
