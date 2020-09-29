<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    protected $table = 'news_category';
    protected $primaryKey = 'news_category_id';

    public function NewsCategoryDetail(){
        return $this->hasMany('\App\NewsCategoryDetail', 'news_category_id', 'news_category_id');
    }
}
