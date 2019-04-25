@extends('laravel-jumbotron-images::jumbotronImages.layout')

@section('content')
    {{$jumbotronImage->title}}
    {{$jumbotronImage->body}}
    {{$jumbotronImage->button_text}}
    {{$jumbotronImage->image_file_name}}
    {{$jumbotronImage->button_url}}
@endsection
