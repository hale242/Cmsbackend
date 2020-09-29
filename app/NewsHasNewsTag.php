<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsHasNewsTag extends Model
{
    protected $table = 'news_has_news_tag';
    protected $primaryKey = 'news_has_news_tag_id';

    public function NewsTag(){
        return $this->hasOne('\App\NewsTag', 'news_tag_id', 'news_tag_id');
    }
}
