<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsHasNewsCategory extends Model
{
    protected $table = 'news_has_news_category';
    protected $primaryKey = 'news_has_news_category_id';

    public function NewsCategory(){
        return $this->hasOne('\App\NewsCategory', 'news_category_id', 'news_category_id');
    }
}
