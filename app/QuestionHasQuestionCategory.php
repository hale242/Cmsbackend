<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionHasQuestionCategory extends Model
{
    protected $table = 'ques_has_ques_category';
    protected $primaryKey = 'ques_has_ques_category_id';

    public function QuestionCategory(){
        return $this->hasOne('\App\QuestionCategory', 'ques_category_id', 'ques_category_id');
    }
}
