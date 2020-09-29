<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    protected $table = 'social';
    protected $primaryKey = 'social_id';

    public function Language(){
        return $this->hasOne('\App\Language', 'languages_id', 'languages_id');
    }
}
