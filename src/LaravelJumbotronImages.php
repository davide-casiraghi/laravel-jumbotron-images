<?php

namespace DavideCasiraghi\LaravelJumbotronImages;

use DavideCasiraghi\LaravelJumbotronImages\Models\JumbotronImage;

class LaravelJumbotronImages
{
    /**
     * Return a Jumbotron image.
     *
     * @param  int  $jumbotronImageId
     * @return \DavideCasiraghi\LaravelJumbotronImages\Models\JumbotronImage
     */
    /*public function getJumbotronImage($jumbotronImageId)
    {
        $jumbotronImage = JumbotronImage::find($jumbotronImageId);
        $jumbotronImage->parameters = $this->getParametersArray($jumbotronImage);

        $ret = $jumbotronImage;

        return $ret;
    }*/

    /***************************************************************************/

    /**
     * Show a Jumbotron Image.
     *
     * @param  int  $jumbotronImageId
     * @return \DavideCasiraghi\LaravelJumbotronImages\Models\JumbotronImage
     */
    public function showJumbotronImage($jumbotronImageId)
    {
        $jumbotronImage = JumbotronImage::find($jumbotronImageId);

        //$jumbotronImageParameters = $this->getParametersArray($jumbotronImage);
        $jumbotronImageParameters = ($jumbotronImage) ? $this->getParametersArray($jumbotronImage) : null;

        return view('laravel-jumbotron-images::show-jumbotron-image', compact('jumbotronImage'))
            ->with('jumbotronImageParameters', $jumbotronImageParameters);
    }

    /***************************************************************************/

    /**
     * Attach to the jumbotron image object an array with the parameters for the show-jumbotron-image view.
     * @param  \DavideCasiraghi\LaravelJumbotronImages\Models\JumbotronImage  $jumbotronImage
     * @return array
     */
    public static function getParametersArray($jumbotronImage)
    {
        $ret = [
             'cover_opacity' => 'opacity: '.$jumbotronImage->cover_opacity.';',
             'background_color' => 'background: #'.$jumbotronImage->background_color.';',
             'image' => 'background-image:url(/storage/images/jumbotron_images/'.$jumbotronImage->image_file_name.');',
             'text_horizontal_alignment' => 'text-align: '.$jumbotronImage->text_horizontal_alignment.';',
         ];
        $ret['white_moon'] = ($jumbotronImage->white_moon == 1) ? ' moon-curve ' : '';
        $ret['scroll_down_arrow'] = ($jumbotronImage->scroll_down_arrow == 1) ? "<div class='scroll-arrow white'><span>SCROLL DOWN</span><img src='/vendor/laravel-jumbotron-images/assets/images/angle-down-regular.svg'></div>" : '';

        /* Parallax - The element is defined with stellar plugin like: <section class="parallax" data-stellar-background-ratio="0.5" ><span>Summer</span></section>*/
        $ret['parallax'] = ($jumbotronImage->parallax == 1) ? ' parallax' : '';
        $ret['parallax_ratio'] = ($jumbotronImage->parallax == 1) ? "data-stellar-background-ratio='0.5'" : '';

        /* Text Width */
        if ($jumbotronImage->text_width != 100) {
            switch ($jumbotronImage->text_horizontal_alignment) {
                case 'left':	// Left
                    $ret['text_width'] = 'width: '.$jumbotronImage->text_width.'%;';
                break;
                case 'center': // Center
                    $ret['text_width'] = 'width: '.$jumbotronImage->text_width.'%; margin: auto;';
                break;
                case 'right': // Right
                    $ret['text_width'] = 'width: '.$jumbotronImage->text_width.'%; float: right;';
                break;
            }
        }

        return $ret;
    }

    /**************************************************************************/

    /**
     *  Find the card snippet occurances in the text.
     *
     *  @param string $text
     *  @return array $matches
     **/
    public static function getJumbotronSnippetOccurrences($text)
    {
        $re = '/{\#
                \h+jumbotron
                \h+(id)=\[([^]]*)]
                \h*\#}/x';

        if (preg_match_all($re, $text, $matches, PREG_SET_ORDER, 0)) {
            return $matches;
        } else {
            return;
        }
    }

    /**************************************************************************/

    /**
     *  Return the same text with the jumbotrons HTML replaced
     *  where the token strings has been found.
     *
     *  @param string $text
     *  @return string $ret
     **/
    public function replaceJumbotronSnippetsWithTemplate($text)
    {
        $matches = self::getJumbotronSnippetOccurrences($text);

        if ($matches) {
            foreach ($matches as $key => $single_jumbotron_matches) {
                $snippetParameters = self::getSnippetParameters($single_jumbotron_matches);
                $jumbotron = self::getJumbotron($snippetParameters['jumbotron_id']);
                $jumbotronView = self::showJumbotronImage($snippetParameters['jumbotron_id']);
                $jumbotronHtml = $jumbotronView->render();

                // Substitute the jumbotron html to the token that has been found
                $text = str_replace($snippetParameters['token'], $jumbotronHtml, $text);
            }
        }

        $ret = $text;

        return $ret;
    }

    /**************************************************************************/

    /**
     *  Provide the post data array (post_title, post_body, post_image).
     *
     *  @param int $jumbotronId
     *  @return  \DavideCasiraghi\LaravelJumbotronImages\Models\JumbotronImage    $ret
     **/
    public static function getJumbotron($jumbotronId)
    {
        $ret = JumbotronImage::where('id', $jumbotronId)->first();

        return $ret;
    }

    /**************************************************************************/

    /**
     *  Returns the snippet parameters.
     *
     *  @param array $matches
     *  @return array $ret
     **/
    public static function getSnippetParameters($matches)
    {
        $ret = [];

        // Get activation string parameters (from article)
        $ret['token'] = $matches[0];
        //dump($matches);
        $ret['jumbotron_id'] = $matches[2];

        //dump($ret);
        return $ret;
    }
}
