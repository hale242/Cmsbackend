<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KnowledgeDetail extends Model
{
    protected $table = 'knowledge_details';
    protected $primaryKey = 'knowledge_details_id';
    
    public function Knowledge()
    {
        return $this->hasOne('\App\Knowledge', 'knowledge_id', 'knowledge_id');
    }
    public function Language()
    {
        return $this->hasOne('\App\Language', 'languages_id', 'languages_id');
    }
}
