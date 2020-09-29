<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionCategoryDetail extends Model
{
    protected $table = 'ques_category_lang';
    protected $primaryKey = 'ques_category_lang_id';

    public function Language(){
        return $this->hasOne('\App\Language', 'languages_id', 'languages_id');
    }
    public function QuestionCategory(){
        return $this->hasOne('\App\QuestionCategory', 'ques_category_id', 'ques_category_id');
    }
}
