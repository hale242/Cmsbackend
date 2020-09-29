<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banner';
    protected $primaryKey = 'banner_id';

    public function BannerDetail(){
        return $this->hasMany('\App\BannerDetail', 'banner_id', 'banner_id');
    }
}
