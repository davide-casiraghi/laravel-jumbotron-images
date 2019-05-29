{{--<div class="jumbotronImage">
    @if($jumbotronImage)
        {{$jumbotronImage->title}}<br />
        {{$jumbotronImage->body}}<br />
        {{$jumbotronImage->button_text}}<br />
        {{$jumbotronImage->image_file_name}}<br />
        aaaaaaaa<br />
        {{$jumbotronImage->jumbotron_height}}<br />
        {{$jumbotronImageParameters['image']}}<br />
        @if(!empty($jumbotronImage->image_file_name))
            <img class="ml-3 float-right img-fluid mb-2" src="/storage/images/jumbotron_images/thumb_{{ $jumbotronImage->image_file_name }}" >
        @endif
        {{$jumbotronImage->button_url}}<br />
    @else
        <div class="alert alert-warning" role="alert">
            No jumbotron corresponding to the specified ID has been found.
        </div>
    @endif
</div>--}}



<div class="jumbotronImage">
    <section class="hero {{$jumbotronImageParameters['white_moon']}} {{$jumbotronImage->jumbotron_height}} {{$jumbotronImageParameters['parallax']}}" style="{{$jumbotronImageParameters['image']}} {{$jumbotronImageParameters['background_color']}} {{$jumbotronImageParameters['parallax']}}" {!!$jumbotronImageParameters['parallax_ratio']!!}>
        <div class="hero-body" style="{{$jumbotronImage->text_vertical_alignment}}">
            
            <div class="container" style="{{$jumbotronImageParameters['text_horizontal_alignment']}} {{$jumbotronImage->text_shadow}}">
                @if($jumbotronImage->title)
                    <h1 class="title mb-4 font-weight-bold">
                        <div class="mb-5" style="{{$jumbotronImageParameters['text_width']}}">{{$jumbotronImage->title}}</div>
                    </h1>
                @endif
                @if($jumbotronImage->body)
                    <div class="subtitle mb-5" style="{{$jumbotronImageParameters['text_width']}}">{{$jumbotronImage->body}}</div>
                @endif
                
                @if ($jumbotronImage->button_url)
                    @include('laravel-jumbotron-images::partials.button', [
                          'text' =>  $jumbotronImage->button_text,
                          'name' => 'button',
                          'url' => $jumbotronImage->button_url,
                          'roundedCorners' => 'true',
                    ])
                @endif
                
                {!!$jumbotronImageParameters['scroll_down_arrow']!!}
                
            </div>
                    
        </div>

        <div class="cover" style="{{$jumbotronImageParameters['cover_opacity']}}"></div>

    </section>
        
    
</div>
