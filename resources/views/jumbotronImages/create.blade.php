@extends('laravel-jumbotron-images::jumbotronImages.layout')

@section('content')

    <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h4>Add new jumbotron image</h4>
                </div>
            </div>

            @include('php-responsive-JumbotronImage::partials.error-management', [
                  'style' => 'alert-danger',
            ])

            <form action="{{ route('jumbotron-images.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    {{-- Title  --}}
                    <div class="col-12">
                        @include('php-responsive-JumbotronImage::partials.input', [
                            'title' => 'Title',
                            'name' => 'title',
                            'placeholder' => '', 
                            'value' => old('title')
                        ])
                    </div>
    
                    {{-- Body --}}
                    <div class="col-12">
                        @include('php-responsive-JumbotronImage::partials.textarea-plain', [
                            'title' =>  'Body',
                            'name' => 'body',
                            'value' => old('body')
                        ])
                    </div>
                    
                    {{-- Button url --}}
                    <div class="col-12">
                        @include('php-responsive-JumbotronImage::partials.input', [
                            'title' =>  'Button url',
                            'name' => 'button_url',
                            'placeholder' => 'https://...', 
                            'value' => old('button_url')
                        ])
                    </div>
                    
                    {{-- Button text --}}
                    <div class="col-12">
                        @include('php-responsive-JumbotronImage::partials.input', [
                            'title' =>  'Button text',
                            'name' => 'button_text',
                            'placeholder' => '', 
                            'value' => old('button_text')
                        ])
                    </div>
        
                    <div class="col-12">
                        @include('php-responsive-JumbotronImage::partials.buttons-back-submit', [
                           'route' => 'jumbotron-images.index'  
                       ])
                    </div>
                                
                </div>
            </form>
    
    </div>
    
@endsection
