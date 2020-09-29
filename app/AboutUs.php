<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    protected $table = 'aboutus_list';
    protected $primaryKey = 'aboutus_list_id';

    public function AboutUsHasAboutUsCategory(){
        return $this->hasMany('\App\AboutUsHasAboutUsCategory', 'aboutus_list_id', 'aboutus_list_id');
    }
}
