@extends('laravel-jumbotron-images::jumbotronImages.layout')

@section('content')

    <div class="container mb-4">
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
                    
                    {{-- Button color --}}
                    <div class="col-12">
                        @include('laravel-jumbotron-images::partials.select', [
                              'title' => "Button color",
                              'name' => 'button_color',
                              'placeholder' => "choose one...", 
                              'records' => $buttonColorArray,
                              'liveSearch' => 'false',
                              'mobileNativeMenu' => true,
                              'seleted' => old('button_color'),
                              'required' => true,
                              'tooltip' => 'Check the press-css.io website for the preview of the color available.',
                        ])
                    </div>

                    {{-- Image --}}
                    @include('laravel-jumbotron-images::partials.upload-image', [
                          'title' => 'Jumbotron background image', 
                          'name' => 'image_file_name',
                          'folder' => 'jumbotron_images',
                          'value' => ''
                    ])
                    
                    <div class="col-12">
                        @include('laravel-jumbotron-images::partials.select', [
                              'title' => "Jumbotron Height",
                              'name' => 'jumbotron_height',
                              'placeholder' => "choose one...", 
                              'records' => $jumbotronHeightArray,
                              'liveSearch' => 'false',
                              'mobileNativeMenu' => true,
                              'seleted' => old('jumbotron_height'),
                              'required' => true,
                              'tooltip' => 'The height is expressed in Bulma size unit like, check Bulma website.',
                        ])
                    </div>
                    
                    <div class="col-12">
                        @include('laravel-jumbotron-images::partials.select', [
                              'title' => "Cover Opacity",
                              'name' => 'cover_opacity',
                              'placeholder' => "choose one...", 
                              'records' => $coverOpacityArray,
                              'liveSearch' => 'false',
                              'mobileNativeMenu' => true,
                              'seleted' => old('cover_opacity'),
                              'required' => true,
                              'tooltip' => 'Add an opaque layer above the background image'
                        ])
                    </div>
                    
                    <div class="col-12">
                        @include('laravel-jumbotron-images::partials.checkbox', [
                              'name' => 'scroll_down_arrow',
                              'description' => 'Show scroll down arrow',
                              'value' => old('scroll_down_arrow'),
                              'required' => false,
                        ])
                    </div>
                    
                    <div class="col-12">
                        @include('laravel-jumbotron-images::partials.checkbox', [
                              'name' => 'parallax',
                              'description' => 'Parallax effect for the background image',
                              'value' => old('parallax'),
                              'required' => false,
                        ])
                    </div>
                    
                    {{-- Background color --}}
                    <div class="col-12">
                        @include('laravel-jumbotron-images::partials.input', [
                            'title' =>  'Background color',
                            'name' => 'background_color',
                            'tooltip' => 'Exadecimal value for the background color. Active if a value is specified.',
                            'placeholder' => '#HEX', 
                            'value' => old('background_color')
                        ])
                    </div>
                    
                    {{-- White moon --}}
                    <div class="col-12">
                        @include('laravel-jumbotron-images::partials.checkbox', [
                              'name' => 'white_moon',
                              'description' => 'White moon under the banner',
                              'value' => old('white_moon'),
                              'required' => false,
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
