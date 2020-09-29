<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsGallery extends Model
{
    protected $table = 'news_gallery';
    protected $primaryKey = 'news_gallery_id';
    
    public function News(){
        return $this->hasOne('\App\News', 'news_id', 'news_id');
    }
}
