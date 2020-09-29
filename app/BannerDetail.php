<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BannerDetail extends Model
{
    protected $table = 'banner_lang';
    protected $primaryKey = 'banner_lang_id';
    
    public function Banner()
    {
        return $this->hasOne('\App\Banner', 'banner_id', 'banner_id');
    }
    public function Language()
    {
        return $this->hasOne('\App\Language', 'languages_id', 'languages_id');
    }
}
