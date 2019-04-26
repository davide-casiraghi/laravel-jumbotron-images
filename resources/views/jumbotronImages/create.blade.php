@extends('laravel-jumbotron-images::jumbotronImages.layout')

@section('content')

    <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h4>Add new jumbotron image</h4>
                </div>
            </div>

            @include('laravel-jumbotron-images::partials.error-management', [
                  'style' => 'alert-danger',
            ])

            <form action="{{ route('jumbotron-images.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    {{-- Title  --}}
                    <div class="col-12">
                        @include('laravel-jumbotron-images::partials.input', [
                            'title' => 'Title',
                            'name' => 'title',
                            'placeholder' => '', 
                            'value' => old('title')
                        ])
                    </div>
    
                    {{-- Body --}}
                    <div class="col-12">
                        @include('laravel-jumbotron-images::partials.textarea-plain', [
                            'title' =>  'Body',
                            'name' => 'body',
                            'value' => old('body')
                        ])
                    </div>
                    
                    {{-- Button url --}}
                    <div class="col-12">
                        @include('laravel-jumbotron-images::partials.input', [
                            'title' =>  'Button url',
                            'name' => 'button_url',
                            'placeholder' => 'https://...', 
                            'value' => old('button_url')
                        ])
                    </div>
                    
                    {{-- Button text --}}
                    <div class="col-12">
                        @include('laravel-jumbotron-images::partials.input', [
                            'title' =>  'Button text',
                            'name' => 'button_text',
                            'placeholder' => '', 
                            'value' => old('button_text')
                        ])
                    </div>
                    
                    {{-- Image file name --}}
                    <div class="col-12">
                        @include('laravel-jumbotron-images::partials.input', [
                            'title' =>  'Image file name',
                            'name' => 'image_file_name',
                            'placeholder' => '', 
                            'value' => old('image_file_name')
                        ])
                    </div>
        
                    <div class="col-12">
                        @include('laravel-jumbotron-images::partials.buttons-back-submit', [
                           'route' => 'jumbotron-images.index'  
                       ])
                    </div>
                                
                </div>
            </form>
    
    </div>
    
@endsection
