<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use File;

class AdminUser extends Authenticatable
{
    protected $table = 'admin_user';
    protected $primaryKey = 'admin_id';

    public function AdminGroup(){
        return $this->hasMany('\App\AdminGroup', 'admin_id', 'admin_id');
    }
    public function DepartmentAdminUser(){
        return $this->hasMany('\App\DepartmentAdminUser', 'admin_id', 'admin_id');
    }
    public function PermissionAction(){
        return $this->hasMany('\App\PermissionAction', 'admin_id', 'admin_id');
    }
    public function Gender(){
        return $this->hasOne('\App\Gender', 'gender_id', 'gender_id');
    }
    public function NamePrefix(){
        return $this->hasOne('\App\NamePrefix', 'name_prefix_id', 'name_prefix_id');
    }
    public function Position(){
        return $this->hasOne('\App\Position', 'position_id', 'position_id');
    }

    public function SaleTeamSubHasAdminUser(){
        return $this->hasMany('\App\SaleTeamSubHasAdminUser', 'admin_id', 'admin_id');
    }

    public function PathImage()
    {
        return 'uploads/AdminUser/';
    }

    public function viewImage()
    {
        $image  = 'uploads/images/no-image.jpg';
        if ($this->image) {
            if (File::exists($this->PathImage().$this->image)) {
                $image = $this->PathImage().$this->image;
            }
        }
        return $image;
    }
}
