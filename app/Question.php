<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'ques';
    protected $primaryKey = 'ques_id';

    public function QuestionHasQuestionCategory(){
        return $this->hasMany('\App\QuestionHasQuestionCategory', 'ques_id', 'ques_id');
    }

    public function QuestionDetail(){
        return $this->hasMany('\App\QuestionDetail', 'ques_id', 'ques_id');
    }
}
