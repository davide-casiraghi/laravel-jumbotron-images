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
        return JumbotronImage::find($id);
    }
}
