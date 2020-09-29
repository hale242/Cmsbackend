<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Knowledge extends Model
{
    protected $table = 'knowledge';
    protected $primaryKey = 'knowledge_id';

    public function KnowledgeHasKnowledgeCategory(){
        return $this->hasMany('\App\KnowledgeHasKnowledgeCategory', 'knowledge_id', 'knowledge_id');
    }

    public function KnowledgeDetail(){
        return $this->hasMany('\App\KnowledgeDetail', 'knowledge_id', 'knowledge_id');
    }
}
