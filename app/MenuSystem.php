<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuSystem extends Model
{
    protected $table = 'menu_system';
    protected $primaryKey = 'menu_system_id';

    public function scopeActiveMenu($a){
        $admin_id = \Auth::guard('admin')->user()->admin_id;
        $PermissionActionByGroups = PermissionActionByGroup::join('admin_group', 'admin_group.admin_user_group_id', 'permission_action_by_group.admin_user_group_id')
            ->where([
              'admin_group.admin_id' => $admin_id,
              'permission_action_by_group.permission_action_by_group_code_action' => 1,
              'permission_action_by_group.permission_action_by_group_status' => 1,
            ])->get();
        $PermissionActions = PermissionAction::where(['admin_id' => $admin_id, 'permission_action_code_action' => 1, 'permission_action_status' => 1])->get();
        $menu_id = [];
        foreach($PermissionActions as $val){
            $menu_id[] = $val->menu_system_id;
        }
        foreach($PermissionActionByGroups as $val){
            $menu_id[] = $val->menu_system_id;
        }
        $menu_id = array_unique($menu_id);
        $a->where('menu_system_status' , 1);
        $a->whereNull('menu_system_main_menu');
        $a->whereIn('menu_system_id', $menu_id);
        $a->orderBy('menu_system_z_index');
        $a->with(['SubMenu'=>function($b) use($menu_id){
            $b->where('menu_system_status' , 1);
            $b->whereIn('menu_system_id', $menu_id);
            $b->orderBy('menu_system_z_index');
        }]);
    }

    public function SubMenu(){
        return $this->hasMany('\App\MenuSystem' ,'menu_system_main_menu' ,'menu_system_id');
    }
    public function MainMenu(){
        return $this->hasOne('\App\MenuSystem' ,'menu_system_id' ,'menu_system_main_menu');
    }
}
