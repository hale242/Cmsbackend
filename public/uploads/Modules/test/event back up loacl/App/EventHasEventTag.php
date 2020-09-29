<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventHasEventTag extends Model
{
    protected $table = 'event_has_event_tag';
    protected $primaryKey = 'event_has_event_tag_id';

    public function EventTag(){
        return $this->hasOne('\App\EventTag', 'event_tag_id', 'event_tag_id');
    }
}
