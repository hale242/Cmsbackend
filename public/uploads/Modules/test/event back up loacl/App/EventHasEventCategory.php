<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventHasEventCategory extends Model
{
    protected $table = 'event_has_event_category';
    protected $primaryKey = 'event_has_event_category_id';

    public function EventCategory(){
        return $this->hasOne('\App\EventCategory', 'event_category_id', 'event_category_id');
    }
}
