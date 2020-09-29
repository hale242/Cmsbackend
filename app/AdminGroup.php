<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminGroup extends Model
{
    protected $table = 'admin_group';
    protected $primaryKey = 'admin_group_id';

    public function AdminUserGroup(){
        return $this->hasOne('\App\AdminUserGroup', 'admin_user_group_id', 'admin_user_group_id');
    }
}
