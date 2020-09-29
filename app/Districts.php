<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Districts extends Model
{
    protected $table = 'districts';
    protected $primaryKey = 'districts_id';

    public function Provinces(){
        return $this->hasOne('\App\Provinces', 'provinces_id', 'provinces_id');
    }
    public function Amphures(){
        return $this->hasOne('\App\Amphures', 'amphures_id', 'amphures_id');
    }
    public function Geography(){
        return $this->hasOne('\App\Geography', 'geo_id', 'geo_id');
    }
    public function Zipcode(){
        return $this->hasOne('\App\Zipcode', 'districts_code', 'districts_code');
    }
}
