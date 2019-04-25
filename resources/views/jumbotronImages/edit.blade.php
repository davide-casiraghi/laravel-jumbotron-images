@extends('laravel-jumbotron-images::jumbotronImages.layout')

@section('content')

    <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h4>Edit jumbotron image</h4>
                </div>
            </div>

            @include('php-responsive-JumbotronImage::partials.error-management', [
                  'style' => 'alert-danger',
            ])

            <form action="{{ route('jumbotron-images.update', $quote->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    
                    {{-- Author  --}}
                    <div class="col-12">
                        @include('php-responsive-JumbotronImage::partials.input', [
                            'title' => 'Author',
                            'name' => 'author',
                            'placeholder' => '', 
                            'value' => $quote->author
                        ])
                    </div>
    
                    {{-- Text --}}
                    <div class="col-12">
                        @include('php-responsive-JumbotronImage::partials.textarea-plain', [
                            'title' =>  'Text',
                            'name' => 'text',
                            'value' => $quote->text
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
