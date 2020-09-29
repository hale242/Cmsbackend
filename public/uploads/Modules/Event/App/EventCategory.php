<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    protected $table = 'event_category';
    protected $primaryKey = 'event_category_id';

    public function EventCategoryDetail(){
        return $this->hasMany('\App\EventCategoryDetail', 'event_category_id', 'event_category_id');
    }
}
