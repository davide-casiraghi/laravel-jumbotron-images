@extends('laravel-jumbotron-images::jumbotronImages.layout')

@section('content')
    {{$quote->author}}
    {{$quote->text}}
@endsection
