<div class="jumbotronImage">
    @if($jumbotronImage)
        {{$jumbotronImage->title}}<br />
        {{$jumbotronImage->body}}<br />
        {{$jumbotronImage->button_text}}<br />
        {{$jumbotronImage->image_file_name}}<br />
        aaaaaaaa<br />
        {{$jumbotronImage->jumbotron_height}}<br />
        {{$jumbotronImage->parameters['image']}}<br />
        @if(!empty($jumbotronImage->image_file_name))
            <img class="ml-3 float-right img-fluid mb-2" src="/storage/images/jumbotron_images/thumb_{{ $jumbotronImage->image_file_name }}" >
        @endif
        {{$jumbotronImage->button_url}}<br />
    @else
        <div class="alert alert-warning" role="alert">
            No jumbotron corresponding to the specified ID has been found.
        </div>
    @endif
</div>


{{--
<div class="jumbotronImage">
    <section class="hero {{$jumbotronImage->parameters['white_moon']}} {{$jumbotronImage->jumbotron_height}} {{$jumbotronImage->parameters['parallax']}}" style="{{$jumbotronImage->parameters['image']}} {{$jumbotronImage->parameters['background_color']}} {{$jumbotronImage->parameters['parallax']}}" {{$jumbotronImage->parameters['parallax_ratio']}}>
        <div class="hero-body" style="{{$jumbotronImage->parameters['vertical_text_alignment']}}">
            
            <div class="container" style="{{$jumbotronImage->parameters['horizontal_text_alignment']}} {{$jumbotronImage->parameters['text_shadow']}}">
                @if($jumbotronImage->title)
                    <h1 class="title">
                        <p style="{{$parameters['text_width']}}">{{$jumbotronImage->title}}</p>
                    </h1>
                @endif
                @if($jumbotronImage->body)
                    <h2 class="subtitle">
                        <p style="{{$jumbotronImage->parameters['text_width']}}">{{$jumbotronImage->body}}</p>
                    </h2>
                @endif
                
                @include('partials.forms.button', [
                      'text' =>  $jumbotronImage->button_text,
                      'name' => 'button',
                      'url' => button_url,
                      'roundedCorners' => 'true',
                ])
                
                {{$jumbotronImage->parameters['scroll_down_arrow']}}
                
            </div>
                    
        </div>

        <div class="cover" style="{{$jumbotronImage->cover_opacity}}"></div>

    </section>
        
    
</div>
--}}
