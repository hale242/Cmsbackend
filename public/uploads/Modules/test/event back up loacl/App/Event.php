<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'event';
    protected $primaryKey = 'event_id';

    public function EventHasEventCategory(){
        return $this->hasMany('\App\EventHasEventCategory', 'event_id', 'event_id');
    }
    public function EventHasEventTag(){
        return $this->hasMany('\App\EventHasEventTag', 'event_id', 'event_id');
    }
    public function EventDetail(){
        return $this->hasMany('\App\EventDetail', 'event_id', 'event_id');
    }
    public function EventGallery(){
        return $this->hasMany('\App\EventGallery', 'event_id', 'event_id');
    }
}
