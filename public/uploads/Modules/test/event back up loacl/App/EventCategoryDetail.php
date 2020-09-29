<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventCategoryDetail extends Model
{
    protected $table = 'event_category_details';
    protected $primaryKey = 'event_category_details_id';

    public function Language(){
        return $this->hasOne('\App\Language', 'languages_id', 'languages_id');
    }
    public function EventCategory(){
        return $this->hasOne('\App\EventCategory', 'event_category_id', 'event_category_id');
    }
}
