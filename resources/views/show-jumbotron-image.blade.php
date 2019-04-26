<div class="jumbotronImage">
    @if($jumbotronImage)
        {{$jumbotronImage->title}}
        {{$jumbotronImage->body}}
        {{$jumbotronImage->button_text}}
        {{$jumbotronImage->image_file_name}}
        @if(!empty($jumbotronImage->image_file_name))
            <img class="ml-3 float-right img-fluid mb-2" src="/storage/images/jumbotron_images/thumb_{{ $jumbotronImage->image_file_name }}" >
        @endif
        {{$jumbotronImage->button_url}}
    @else
        <div class="alert alert-warning" role="alert">
            No jumbotron corresponding to the specified ID has been found.
        </div>
    @endif
</div>


{{--
<div class="jumbotronImage">
    <section class="hero {{$parameters['white_moon']}} {{$parameters['banner_height']}} {{$parameters['parallax']}} {{$parameters['banner_height']}}" style="{{$parameters['image']}} {{$parameters['background_color']}} {{$parameters['parallax']}}" {{$parameters['parallax_ratio']}}>
        <div class="hero-body" style="{{$parameters['vertical_text_alignment']}}">
            
            <div class="container" style="{{$parameters['horizontal_text_alignment']}} {{$parameters['text_shadow']}}">
                <h1 class="title" style="{{$parameters['title_font_size']}} {{$parameters['title_font_weight']}} {{$parameters['title_font_family']}}">
                    <p style="{{$parameters['text_width']}}">{{$parameters['title']}}</p>
                </h1>
                <h2 class="subtitle" style="{{$parameters['description_font_size']}} {{$parameters['description_font_weight']}}">
                    <p style="{{$parameters['text_width']}} {{$parameters['description_font_family']}}">{{$parameters['description']}}</p>
                </h2>

                {{$parameters['button']}}

                {{$parameters['scroll_indicator']}}
                
            </div>
                    
        </div>

        <div class="cover" style="{{$parameters['opacity']}}"></div>

    </section>
        
    
</div>
--}}
