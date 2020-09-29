<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutUsHasAboutUsCategory extends Model
{
    protected $table = 'aboutus_list_has_aboutus_category';
    protected $primaryKey = 'aboutus_list_has_aboutus_category_id';

    public function AboutUsCategory(){
        return $this->hasOne('\App\AboutUsCategory', 'aboutus_category_id', 'aboutus_category_id');
    }
}
