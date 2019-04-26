@extends('laravel-jumbotron-images::jumbotronImages.layout')

@section('content')

    <div class="container mb-4">
            <div class="row mb-4">
                <div class="col-12">
                    <h4>Edit jumbotron image</h4>
                </div>
            </div>

            @include('laravel-jumbotron-images::partials.error-management', [
                  'style' => 'alert-danger',
            ])

            <form action="{{ route('jumbotron-images.update', $jumbotronImage->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    
                    {{-- Title  --}}
                    <div class="col-12">
                        @include('laravel-jumbotron-images::partials.input', [
                            'title' => 'Title',
                            'name' => 'title',
                            'placeholder' => '', 
                            'value' => $jumbotronImage->title
                        ])
                    </div>
                    
                    {{-- Body --}}
                    <div class="col-12">
                        @include('laravel-jumbotron-images::partials.textarea-plain', [
                            'title' =>  'Body',
                            'name' => 'body',
                            'value' => $jumbotronImage->body
                        ])
                    </div>
                    
                    {{-- Button url --}}
                    <div class="col-12">
                        @include('laravel-jumbotron-images::partials.input', [
                            'title' =>  'Button url',
                            'name' => 'button_url',
                            'placeholder' => 'https://...', 
                            'value' => $jumbotronImage->button_url
                        ])
                    </div>
                    
                    {{-- Button text --}}
                    <div class="col-12">
                        @include('laravel-jumbotron-images::partials.input', [
                            'title' =>  'Button text',
                            'name' => 'button_text',
                            'placeholder' => '', 
                            'value' => $jumbotronImage->button_text
                        ])
                    </div>
                    
                    {{-- Image --}}
                    @include('laravel-jumbotron-images::partials.upload-image', [
                          'title' => 'Jumbotron background image', 
                          'name' => 'image_file_name',
                          'folder' => 'jumbotron_images',
                          'value' => $jumbotronImage->image_file_name
                    ])
                                  
                    
                    <div class="col-12">
                        @include('laravel-jumbotron-images::partials.buttons-back-submit', [
                            'route' => 'jumbotron-images.index'  
                        ])
                    </div>
                </div>
            </form>
    
    </div>
    
@endsection
