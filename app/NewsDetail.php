<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsDetail extends Model
{
    protected $table = 'news_details';
    protected $primaryKey = 'news_details_id';
    
    public function News(){
        return $this->hasOne('\App\News', 'news_id', 'news_id');
    }
    public function Language(){
        return $this->hasOne('\App\Language', 'languages_id', 'languages_id');
    }
}
