<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionCategory extends Model
{
    protected $table = 'ques_category';
    protected $primaryKey = 'ques_category_id';

    public function QuestionCategoryDetail(){
        return $this->hasMany('\App\QuestionCategoryDetail', 'ques_category_id', 'ques_category_id');
    }
}
