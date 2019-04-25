
<?php

namespace DavideCasiraghi\PhpResponsiveRandomQuote\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class JumbotronImage extends Model
{
    protected $table = 'jumbotron_images';

    use Translatable;

    public $translatedAttributes = ['title', 'body', 'button_text'];
    protected $fillable = [
        'image_name',
        'button_url',
    ];

    
}
