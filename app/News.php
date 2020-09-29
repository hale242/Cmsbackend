<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';
    protected $primaryKey = 'news_id';

    public function NewsHasNewsCategory(){
        return $this->hasMany('\App\NewsHasNewsCategory', 'news_id', 'news_id');
    }
    public function NewsHasNewsTag(){
        return $this->hasMany('\App\NewsHasNewsTag', 'news_id', 'news_id');
    }
    public function NewsDetail(){
        return $this->hasMany('\App\NewsDetail', 'news_id', 'news_id');
    }
    public function NewsGallery(){
        return $this->hasMany('\App\NewsGallery', 'news_id', 'news_id');
    }
}
