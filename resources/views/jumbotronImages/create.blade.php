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
                    {{-- Author  --}}
                    <div class="col-12">
                        @include('php-responsive-JumbotronImage::partials.input', [
                            'title' => 'Author',
                            'name' => 'author',
                            'placeholder' => '', 
                            'value' => old('author')
                        ])
                    </div>
    
                    {{-- Text --}}
                    <div class="col-12">
                        @include('php-responsive-JumbotronImage::partials.textarea-plain', [
                            'title' =>  'Text',
                            'name' => 'text',
                            'value' => old('text')
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
