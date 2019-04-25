<?php

namespace DavideCasiraghi\PhpResponsiveRandomQuote\Models;

use Illuminate\Database\Eloquent\Model;

class JumbotronImageTranslation extends Model
{
    protected $table = 'jumbotron_images_translations';

    public $timestamps = false;
    protected $fillable = [
        'title', 
        'body', 
        'button_text'
    ];
}
