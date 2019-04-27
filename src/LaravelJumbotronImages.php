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
    public function getJumbotronImage($id)
    {
        $jumbotronImage = JumbotronImage::find($id);
        
        $ret = $jumbotronImage;
        $ret['params'] = $this->getParametersArray($jumbotronImage);
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
        $jumbotronParameters = $this->getParametersArray($jumbotronImage);
        
        return view('laravel-jumbotron-images::jumbotronImages.show', compact('jumbotronImage'));
    }
    
    /***************************************************************************/
    
    /**
     * Return and array with the parameters for the show-jumbotron-image view.
     *
     * @return array
     */
    public static function getParametersArray($jumbotronImage)
    {   
        $ret = [
                 'opacity' => 'opacity: '.$jumbotronImage->opacity.';',
                 'background_color' => "background: #".$jumbotronImage->background_color.";",
                 'image' => "background-image:url(images/banners/".$jumbotronImage->image_file_name.");",
                 'banner_height' => $jumbotronImage->bannerheight,
             ];
             
            /* Parallax - The element is defined with stellar plugin like: <section class="parallax" data-stellar-background-ratio="0.5" ><span>Summer</span></section>*/
            if ($jumbotronImage->parallax == 1){
				$ret['parallax'] = " parallax";
				$ret['parallax_ratio'] = "data-stellar-background-ratio='0.5'";
			}
             
             if ($jumbotronImage->white_moon == 1){
                $ret['white_moon'] = " moon-curve ";
    		 }

        return $ret;
    }

}
