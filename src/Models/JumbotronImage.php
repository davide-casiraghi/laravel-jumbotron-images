<?php

namespace DavideCasiraghi\LaravelJumbotronImages\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class JumbotronImage extends Model
{
    protected $table = 'jumbotron_images';

    use Translatable;

    public $translatedAttributes = ['title', 'body', 'button_text'];
    protected $fillable = [
        'image_file_name',
        'button_url',
        'jumbotron_height',
        'cover_opacity',
        'scroll_down_arrow',
    ];
}
