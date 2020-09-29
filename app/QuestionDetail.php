<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionDetail extends Model
{
    protected $table = 'ques_lang';
    protected $primaryKey = 'ques_lang_id';
    
    public function Question()
    {
        return $this->hasOne('\App\Question', 'ques_id', 'ques_id');
    }
    public function Language()
    {
        return $this->hasOne('\App\Language', 'languages_id', 'languages_id');
    }
}
