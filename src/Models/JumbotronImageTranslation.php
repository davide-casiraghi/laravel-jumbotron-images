<?php

namespace DavideCasiraghi\LaravelJumbotronImages\Models;

use Illuminate\Database\Eloquent\Model;

class JumbotronImageTranslation extends Model
{
    protected $table = 'jumbotron_image_translations';

    public $timestamps = false;
    protected $fillable = [
        'jumbotron_image_id',
        'title',
        'body',
        'button_text',
        'locale',
    ];
}
