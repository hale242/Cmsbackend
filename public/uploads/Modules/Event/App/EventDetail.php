<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventDetail extends Model
{
    protected $table = 'event_details';
    protected $primaryKey = 'event_details_id';
    
    public function Event(){
        return $this->hasOne('\App\Event', 'event_id', 'event_id');
    }
    public function Language(){
        return $this->hasOne('\App\Language', 'languages_id', 'languages_id');
    }
}
