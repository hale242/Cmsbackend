<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventGallery extends Model
{
    protected $table = 'event_gallery';
    protected $primaryKey = 'event_gallery_id';
    
    public function Event(){
        return $this->hasOne('\App\Event', 'event_id', 'event_id');
    }
}
