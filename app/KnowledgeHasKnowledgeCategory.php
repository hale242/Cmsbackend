<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KnowledgeHasKnowledgeCategory extends Model
{
    protected $table = 'knowledge_has_knowledge_category';
    protected $primaryKey = 'knowledge_has_knowledge_category_id';

    public function KnowledgeCategory(){
        return $this->hasOne('\App\KnowledgeCategory', 'knowledge_category_id', 'knowledge_category_id');
    }
}
