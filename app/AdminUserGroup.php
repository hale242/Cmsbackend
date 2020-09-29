<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminUserGroup extends Model
{
    protected $table = 'admin_user_group';
    protected $primaryKey = 'admin_user_group_id';

    public function PermissionActionByGroup(){
          return $this->hasMany('App\PermissionActionByGroup', 'admin_user_group_id', 'admin_user_group_id');
    }
}
