<?php

namespace DavideCasiraghi\LaravelJumbotronImages;

use DavideCasiraghi\LaravelJumbotronImages\Models\JumbotronImage;

class LaravelJumbotronImages
{
    /**
     * Return a random quote.
     *
     * @return \DavideCasiraghi\LaravelJumbotronImages\Models\JumbotronImage
     */
    public function getJumbotronImage($jumbotronImageId)
    {
        $jumbotronImage = JumbotronImage::find($jumbotronImageId);
        $jumbotronImage->parameters = $this->getParametersArray($jumbotronImage);
        
        $ret = $jumbotronImage;
        
        return $ret;
    }

    /*****************************/

    /**
     * Show a Jumbotron Image.
     *
     * @return \DavideCasiraghi\LaravelJumbotronImages\Models\JumbotronImage
     */
    public function showJumbotronImage($jumbotronImageId)
    {
        $jumbotronImage = JumbotronImage::find($jumbotronImageId);
        $jumbotronImage->parameters = $this->getParametersArray($jumbotronImage);
        
        return view('laravel-jumbotron-images::jumbotronImages.show', compact('jumbotronImage'));
    }

    /***************************************************************************/

    /**
     * Attach to the jumbotron image object an array with the parameters for the show-jumbotron-image view.
     *
     * @return array
     */
    public static function getParametersArray($jumbotronImage)
    {
        $ret = [
             'cover_opacity' => 'opacity: '.$jumbotronImage->cover_opacity.';',
             'background_color' => 'background: #'.$jumbotronImage->background_color.';',
             'image' => 'background-image:url(/storage/images/jumbotron_images/'.$jumbotronImage->image_file_name.');',
         ];

        /* Parallax - The element is defined with stellar plugin like: <section class="parallax" data-stellar-background-ratio="0.5" ><span>Summer</span></section>*/
        if ($jumbotronImage->parallax == 1) {
            $ret['parallax'] = ' parallax';
            $ret['parallax_ratio'] = "data-stellar-background-ratio='0.5'";
        }

        if ($jumbotronImage->white_moon == 1) {
            $ret['white_moon'] = ' moon-curve ';
        }

        /* Scroll down arrow */
        if ($jumbotronImage->scroll_down_arrow == 1) {
            $ret['scroll_down_arrow'] = "<div class='scroll-arrow white'><span>SCROLL DOWN</span><img src='/vendor/laravel-jumbotron-images/assets/images/angle-down-regular.svg'></div>";
        }

        switch ($jumbotronImage->text_horizontal_alignment) {
            case 0:
                $ret['text_horizontal_alignment'] = 'text-align: left;';
                break;
            case 1:
                $ret['text_horizontal_alignment'] = 'text-align: center;';
                break;
            case 2:
                $ret['text_horizontal_alignment'] = 'text-align: right;';
                break;
        }

        if ($jumbotronImage->text_width != 100) {
            switch ($jumbotronImage->text_horizontal_alignment) {
                case 0:	// Left
                    $ret['text_width'] = 'width: '.$jumbotronImage->text_width.'%;';
                break;
                case 1: // Center
                    $ret['text_width'] = 'width: '.$jumbotronImage->text_width.'%; margin: auto;';
                break;
                case 2: // Right
                    $ret['text_width'] = 'width: '.$jumbotronImage->text_width.'%; float: right;';
                break;
            }
        }

        return $ret;
    }
}
