<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KnowledgeCategory extends Model
{
    protected $table = 'knowledge_category';
    protected $primaryKey = 'knowledge_category_id';

    public function KnowledgeCategoryDetail(){
        return $this->hasMany('\App\KnowledgeCategoryDetail', 'knowledge_category_id', 'knowledge_category_id');
    }
}
