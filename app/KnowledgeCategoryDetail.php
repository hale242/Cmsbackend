<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KnowledgeCategoryDetail extends Model
{
    protected $table = 'knowledge_category_details';
    protected $primaryKey = 'knowledge_category_details_id';

    public function Language(){
        return $this->hasOne('\App\Language', 'languages_id', 'languages_id');
    }
    public function KnowledgeCategory(){
        return $this->hasOne('\App\KnowledgeCategory', 'knowledge_category_id', 'knowledge_category_id');
    }
}
